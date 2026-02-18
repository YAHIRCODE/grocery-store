<?php

namespace App\Http\Controllers;
use App\Models\client;
use App\Models\Client_debt;
use Illuminate\Http\Request;

class ClientDebtController extends Controller
{


public function validateClientDebt(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'required|date|after:today',
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //
        $debts = Client_debt::with('client')->get();
        return view('client_debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $clients = client::all();
        return view('client_debts.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_id'=>'nullable|exists:sales,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:today',
            'balance_due' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);
        Client_debt::create($request->all());// este va a a ttraer todos los datos del request y los va a guardar en la base de datos, siempre y cuando el modelo tenga el fillable con los campos correctos
        return redirect()->route('client_debts.index')->with('success', 'Deuda del cliente creada exitosamente');
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
    public function edit(string $id)
    {
        //
        $debt = Client_debt::findOrFail($id);
        $clients = client::all();
        return view('client_debts.edit', compact('debt', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $debt = Client_debt::findOrFail($id);
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'sale_id'=>'nullable|exists:sales,id',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after:today',
            'balance_due' => 'required|numeric|min:0.01',
            'status' => 'required|in:pending,paid,overdue',
        ]);
        $debt->update($request->all());
        return redirect()->route('client_debts.index')->with('success', 'Deuda del cliente actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $debt = Client_debt::findOrFail($id);
        if ($debt->status == 'pendiente'){
            return redirect()->back()->with('error', 'No se puede eliminar una deuda pendiente. Por favor, actualice el estado a pagada o vencida antes de eliminar.');         
        }
        $debt->delete();
        return redirect()->route('client_debts.index')->with('success', 'Deuda del cliente eliminada exitosamente');
    }
}
