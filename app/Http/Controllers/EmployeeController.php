<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use APP\Models\employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = employee::with('role')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('employees.create');
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
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:255',
            'payroll_id' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric',
            'card_number' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);
        employee::create($request->all());// este se trae todos los datos de los request y los guarda en la base de datos, siempre y cuando el modelo tenga el fillable con los campos correctos
        return redirect()->route('employees.index')->with('success', 'Empleado creado exitosamente');
        //este solo retorna una vista y no hace nada con los datos, por eso es importante validar los datos antes de crear el registro en la base de datos
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
    public function edit(Request $request, string $id)
    {
        //
        $employee = employee::findOrFail($id);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:255',
            'payroll_id' => 'required|string|max:255',
            'hourly_rate' => 'required|numeric',
            'card_number' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);
        //este va a crear el registro de forma manual, pero es importante validar los datos antes de crear el registro en la base de datos
        employee::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'full_address' => $request->full_address,
            'payroll_id' => $request->payroll_id,
            'hourly_rate' => $request->hourly_rate,
            'card_number' => $request->card_number,
            'role_id' => $request->role_id,
        ]);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employee = employee::findOrFail($id);
        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $employee = employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Empleado eliminado exitosamente');
    }
}
