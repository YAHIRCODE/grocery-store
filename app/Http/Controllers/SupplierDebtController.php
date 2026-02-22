<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\InventoryAdjustment;

class SupplierDebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $adjustments = InventoryAdjustment::with('product')->get();
        return view('supplier_debts.index', compact('adjustments'));
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
            'supplier_id' => 'required|exists:suppliers,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date' // Fecha en la que debes pagar
        ]);
        $product = Product::findOrFail($request->product_id);
        $product->increment('stock', $request->quantity);// se ajusta el stock del producto
        InventoryAdjustment::create($request->all());
        return redirect()->route('supplier_debts.index')->with('success', 'Ajuste registrado exitosamente');    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, $request)
    {
        //
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
        ]);
        $adjustment = InventoryAdjustment::findOrFail($id);
        $product = Product::findOrFail($request->product_id);
        $product->decrement('stock', $request->quantity);// se ajusta el stock del producto
        $adjustment->update($request->all());
        return redirect()->route('supplier_debts.index')->with('success', 'Ajuste actualizado exitosamente');   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $adjustment = InventoryAdjustment::findOrFail($id);
        $product = Product::findOrFail($adjustment->product_id);
        $product->decrement('stock', $adjustment->quantity);// se ajusta el stock del producto
        $adjustment->delete();
        return redirect()->route('supplier_debts.index')->with('success', 'Ajuste eliminado exitosamente');
    }
}
