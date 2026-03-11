<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('name', 'asc')->get();
        return view('products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.createProduct', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0.01',
            'purchase_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Asegurar que el stock tenga un valor por defecto
        $validated['stock'] = $validated['stock'] ?? 0;

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0.01',
            'purchase_price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
 public function destroy(string $id)
{
    try {
        $product = Product::findOrFail($id);

        Log::info('=== INICIO DESTROY ===');
        Log::info('Producto encontrado', [
            'id' => $product->id,
            'name' => $product->name,
            'deleted_at' => $product->deleted_at,
        ]);
        
        // Verificar si tiene ventas
        $ventasCount = $product->sales()->count();
        Log::info('Ventas encontradas', ['count' => $ventasCount]);
        
        if ($ventasCount > 0) {
            Log::warning('BLOQUEADO: Tiene ventas');
            return redirect()
                ->back()
                ->with('warning', "No se puede eliminar: tiene {$ventasCount} ventas.");
        }

        // ELIMINAR
        Log::info('Ejecutando delete()...');
        $result = $product->delete();
        Log::info('Resultado de delete()', ['result' => $result]);

        // Verificar después
        $product->refresh();
        Log::info('DESPUÉS DE ELIMINAR', [
            'id' => $product->id,
            'name' => $product->name,
            'deleted_at' => $product->deleted_at,
        ]);

        Log::info('=== FIN DESTROY ===');

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado correctamente');
            
    } catch (\Exception $e) {
        Log::error('ERROR EN DESTROY', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        
        return redirect()
            ->back()
            ->with('error', 'Error al eliminar: ' . $e->getMessage());
    }
}
    public function trashed()
    {
        $products = Product::onlyTrashed()
            ->with('category')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('products.trashed', compact('products'));
    }
    // este es para restaurar un producto eliminado
    public function restore(string $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto restaurado exitosamente');
    }

    //este solo es borrar pernamente si es que el producto deja de existir 
    public function forceDelete(string $id)
    {
        // Solo administradores pueden eliminar permanentemente
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para eliminar permanentemente productos');
        }

        $product = Product::onlyTrashed()->findOrFail($id);

        // Verificar que no tenga ventas
        if ($product->sales()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'No se puede eliminar permanentemente porque tiene ventas registradas.');
        }

        // Eliminar PERMANENTEMENTE (se borra de la BD)
        $product->forceDelete();

        return redirect()
            ->route('products.trashed')
            ->with('success', 'Producto eliminado permanentemente de la base de datos');
    }
}
