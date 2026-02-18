<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //validar los datos del formulario
        $categories = Category::all();
        return view('products.create', compact('categories'));
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        // crear el registro de forma manual
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
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
        $product = Product::findorFail($id);// este busca los productos especificos 
        $categories = Category::all();//trae todas las categorias
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $product  = Product::findOrFail($id);
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'required|string',
            'price'=>'required|numeric|min:0',
            'category_id'=>'required|exists:categories,id'
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product  = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }
}
