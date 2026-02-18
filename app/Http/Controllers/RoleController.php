<?php

namespace App\Http\Controllers;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
        $roles = Role::all();// este va a traere todos los roles de la base de datos y los va a guardar en la variable $roles, esta variable se va a pasar a la vista para mostrarla en un select o algo asi
        return view('roles.create', compact('roles'));// esta va a retornar la vista de roles.create y le va a pasar la variable $roles, esta variable se puede usar en la vista con $roles

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'rol_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]); 
        Role::create($request->all());
        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente');// en esta va a redirigir a la ruta de roles.index y va a mostrar un mensaje de exito, este mensaje se puede mostrar en la vista con session('success')
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'rol_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        $role = Role::findOrFail($id);
        $role->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
            $role = Role::findOrFail($id);
            $role->delete();
            return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
