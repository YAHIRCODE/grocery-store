<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDebt;
use Illuminate\Http\Request;

class ClientDebtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = ClientDebt::with('client')->orderBy('due_date', 'asc')->get();
        return view('client_debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('client_debts.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_id' => 'nullable|exists:sales,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'balance_due' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        ClientDebt::create($validated);
        
        return redirect()
            ->route('client_debts.index')
            ->with('success', 'Deuda del cliente creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $debt = ClientDebt::with('client')->findOrFail($id);
        return view('client_debts.show', compact('debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $debt = ClientDebt::findOrFail($id);
        $clients = Client::all();
        return view('client_debts.edit', compact('debt', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $debt = ClientDebt::findOrFail($id);
        
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_id' => 'nullable|exists:sales,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:start_date',
            'balance_due' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);

        $debt->update($validated);
        
        return redirect()
            ->route('client_debts.index')
            ->with('success', 'Deuda del cliente actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $debt = ClientDebt::findOrFail($id);
        
        // No permitir eliminar deudas pendientes
        if (in_array($debt->status, ['pending', 'overdue'])) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar una deuda pendiente o vencida. Por favor, actualice el estado a pagada antes de eliminar.');
        }
        
        $debt->delete();
        
        return redirect()
            ->route('client_debts.index')
            ->with('success', 'Deuda del cliente eliminada exitosamente');
    }
}