<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryAdjustment;
use App\Models\Product;

class InventoryAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $adjustments = InventoryAdjustment::with('product')->get();
        return view('inventory_adjustments.index', compact('adjustments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        return view('inventory_adjustments.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'adjustment_type' => 'required|in:addition,subtraction',
            'reason' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validación extra para mermas/salidas
        if ($request->adjustment_type === 'subtraction' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'No hay suficiente stock para realizar este ajuste (Stock actual: ' . $product->stock . ')'])->withInput();
        }

        // Usamos una transacción para asegurar la integridad de los datos
        DB::transaction(function () use ($request, $product) {
            // Lógica condicional según el tipo de ajuste
            if ($request->adjustment_type === 'addition') {
                $product->increment('stock', $request->quantity);
            } else {
                $product->decrement('stock', $request->quantity);
            }

            // Crear el registro
            InventoryAdjustment::create($request->all());
        });

        return redirect()->route('inventory_adjustments.index')
            ->with('success', 'Ajuste registrado y stock actualizado exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $adjustment = InventoryAdjustment::findOrFail($id);
        return view('inventory_adjustments.show', compact('adjustment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $adjustment = InventoryAdjustment::findOrFail($id);
        $products = Product::all();
        return view('inventory_adjustments.edit', compact('adjustment', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);
        $adjustment = InventoryAdjustment::findOrFail($id);
        $product = Product::findOrFail($request->product_id);
        $product->decrement('stock', $request->quantity); // se ajusta el stock del producto
        $adjustment->update($request->all());
        return redirect()->route('inventory_adjustments.index')->with('success', 'Ajuste actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $adjustment = InventoryAdjustment::findOrFail($id);
        $product = Product::findOrFail($adjustment->product_id);
        $product->decrement('stock', $adjustment->quantity); // se ajusta el stock del producto
        $adjustment->delete();
    }
}
