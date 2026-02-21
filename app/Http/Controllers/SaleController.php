<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sales = Sale::all();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0.01',
        ]);
        // inicio de la trasaccion
        DB::beginTransaction();
         $employee_id = auth()->user()->id;
        try{
            $product = Product::findOrFail($request->product_id);
            //analisis de progreso
            if ($product->stock < $request->quantity){
                return redirect()->back()->with('error', 'No hay suficiente stock para realizar la venta');
            }
        //regiatrar la venta 
        $total = $product->price*$request->quantity;
        $sale = Sale::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total,
            'employee_id' => auth()->Employee()->id,
        ]);
        // restar el stock del producto
        $product->decrement('stock', $request->quantity);
        DB::commit();
        return redirect()->route('sales.index')->with('success', 'Venta registrada exitosamente');
        //actualizar el stock del producto
        // $product->update([
        //     'stock' => $product->stock - $request->quantity
        // ]);
        // DB::commit();
        // return redirect()->route('sales.index')->with('success', 'Venta registrada exitosamente');
        }catch(\Exception $e){
            DB::rollBack();// esta desase todo 
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la venta: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $sale = Sale::findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $sale = Sale::findOrFail($id);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0.01',
        ]);
        $sale->update($request->all());
        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente');
    }
}
