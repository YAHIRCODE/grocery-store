<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierDebt;
use App\Models\Supplier;

class SupplierDebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las deudas con su proveedor asociado
        $debts = SupplierDebt::with('supplier')->get();
        return view('supplier_debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('supplier_debts.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        // Crear la deuda con los datos validados
        SupplierDebt::create($validated);
        
        return redirect()
            ->route('supplier_debts.index')
            ->with('success', 'Deuda del proveedor creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $debt = SupplierDebt::with('supplier')->findOrFail($id);
        return view('supplier_debts.show', compact('debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $debt = SupplierDebt::findOrFail($id);
        $suppliers = Supplier::all();
        return view('supplier_debts.edit', compact('debt', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $debt = SupplierDebt::findOrFail($id);
        
        // Validar los datos del formulario
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        // Actualizar con datos validados
        $debt->update($validated);
        
        return redirect()
            ->route('supplier_debts.index')
            ->with('success', 'Deuda del proveedor actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $debt = SupplierDebt::findOrFail($id);

        // No permitir eliminar deudas pendientes o vencidas
        if (in_array($debt->status, ['pending', 'overdue'])) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar una deuda pendiente o vencida.');
        }

        $debt->delete();
        
        return redirect()
            ->route('supplier_debts.index')
            ->with('success', 'Deuda del proveedor eliminada exitosamente');
    }
}