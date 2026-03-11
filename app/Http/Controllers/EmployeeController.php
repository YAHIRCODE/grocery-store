<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('role')->get();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('employees.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:255',
            'payroll_id' => 'required|string|max:255|unique:employees,payroll_id',
            'hourly_rate' => 'required|numeric|min:0.01',
            'card_number' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            // Crear usuario asociado
            $user = User::create([
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'email' => $validated['email'],
                'password' => bcrypt('password'), // Contraseña por defecto
            ]);

            // Crear empleado
            Employee::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'full_address' => $validated['full_address'],
                'payroll_id' => $validated['payroll_id'],
                'hourly_rate' => $validated['hourly_rate'],
                'card_number' => $validated['card_number'],
                'role_id' => $validated['role_id'],
                'user_id' => $user->id,
            ]);

            DB::commit();
            return redirect()
                ->route('employees.index')
                ->with('success', 'Empleado creado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al crear empleado: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::with('role')->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        $roles = Role::all();
        return view('employees.edit', compact('employee', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'phone' => 'required|string|max:20',
            'full_address' => 'required|string|max:255',
            'payroll_id' => 'required|string|max:255|unique:employees,payroll_id,' . $id,
            'hourly_rate' => 'required|numeric|min:0.01',
            'card_number' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $employee->update($validated);
        
        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        
            $ventasCount = $employee->sales()->count();
    if ($ventasCount > 0) {
        return redirect()
            ->back()
            ->with('warning', "No se puede eliminar este empleado porque tiene {$ventasCount} venta(s) registrada(s).");
    }
        $ventasCount = $employee->sales()->count();
    if ($ventasCount > 0) {
        return redirect()
            ->back()
            ->with('warning', "No se puede eliminar este empleado porque tiene {$ventasCount} venta(s) registrada(s).");
    }
        // // Opcional: Eliminar también el usuario asociado
        // if ($employee->user_id) {
        //     User::find($employee->user_id)?->delete();
        // }
        
        $employee->delete();
        
        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado eliminado exitosamente');
    }
}