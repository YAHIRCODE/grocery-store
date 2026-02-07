<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EditorialController extends Controller
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
        return view('editoriales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
   'name' => 'required|min:5',
   'address' => 'required',
   'email' => 'required'
]);


$editorial = new Editorial();
$editorial->name = $request->input('name');
$editorial->address = $request->input('address');
$editorial->email = $request->input('email');
$editorial->status = 1;
$editorial->save();
return redirect()->route('editoriales.index')->with(array(
   'message' => 'La Editorial se ha guardado correctamente'
));

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
    }
}
