<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with(['product', 'employee'])->orderBy('created_at', 'desc')->get();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Obtener empleado autenticado
            $employee = auth()->user()->employee;
            if (!$employee) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('error', 'No se encontró el empleado asociado al usuario autenticado');
            }

            $product = Product::findOrFail($validated['product_id']);

            // Verificar stock disponible
            if ($product->stock < $validated['quantity']) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('error', 'No hay suficiente stock para realizar la venta')
                    ->withInput();
            }

            // Registrar la venta
            $total = $product->price * $validated['quantity'];
            $sale = Sale::create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $total,
                'employee_id' => $employee->id,
            ]);

            // Descontar el stock del producto
            $product->decrement('stock', $validated['quantity']);

            DB::commit();
            Log::info('Venta registrada exitosamente: ' . $sale->id);
            
            return redirect()
                ->route('sales.index')
                ->with('success', 'Venta registrada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar venta: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al registrar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::with(['product', 'employee'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::findOrFail($id);
        $products = Product::all();
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);
            $oldProduct = Product::findOrFail($sale->product_id);
            $newProduct = Product::findOrFail($validated['product_id']);

            // Devolver stock del producto anterior
            $oldProduct->increment('stock', $sale->quantity);

            // Verificar stock del nuevo producto
            if ($newProduct->stock < $validated['quantity']) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->with('error', 'No hay suficiente stock disponible')
                    ->withInput();
            }

            // Descontar stock del nuevo producto
            $newProduct->decrement('stock', $validated['quantity']);

            // Actualizar venta
            $sale->update([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $newProduct->price * $validated['quantity'],
            ]);

            DB::commit();
            return redirect()
                ->route('sales.index')
                ->with('success', 'Venta actualizada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar la venta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $sale = Sale::findOrFail($id);
            $product = Product::findOrFail($sale->product_id);

            // Devolver el stock al producto
            $product->increment('stock', $sale->quantity);

            $sale->delete();

            DB::commit();
            return redirect()
                ->route('sales.index')
                ->with('success', 'Venta eliminada exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }
}