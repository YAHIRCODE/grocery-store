<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\client;
class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'required|string|max:20',
            'street_1' => 'required|string|max:255',
            'street_2' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);
        client::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $client = client::findOrFail($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $client = client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:clients,email,' . $id,
            'street_1' => 'required|string|max:255',
            'street_2' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);
        $client = client::findOrFail($id);
        $client->update($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $client = client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
