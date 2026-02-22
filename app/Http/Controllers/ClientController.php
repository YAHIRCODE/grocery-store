<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::orderBy('first_name', 'asc')->get();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'street_1' => 'required|string|max:255',
            'street_2' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        Client::create($validated);
        
        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::with('debts')->findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'phone' => 'required|string|max:20',
            'street_1' => 'required|string|max:255',
            'street_2' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $client->update($validated);
        
        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        
        // Verificar si el cliente tiene deudas pendientes
        if ($client->debts()->whereIn('status', ['pending', 'overdue'])->exists()) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar el cliente porque tiene deudas pendientes');
        }
        
        $client->delete();
        
        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente eliminado exitosamente');
    }
}