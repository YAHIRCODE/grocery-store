<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;
use App\Models\ClientDebt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PdfController extends Controller
{
    /**
     * Generar PDF de una venta individual
     */
    public function generarVenta($id)
    {
        $sale = Sale::with(['product', 'employee', 'client'])->findOrFail($id);
        
        $pdf = Pdf::loadView('pdfs.venta', compact('sale'));
        
        return $pdf->download('venta_' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Reporte de ventas diarias
     */
    public function reporteVentasDiarias()
    {
        $fecha = Carbon::today();
        
        $ventas = Sale::with(['product', 'employee', 'client'])
            ->whereDate('created_at', $fecha)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalVentas = $ventas->sum('total_price');
        $totalTransacciones = $ventas->count();
        
        $pdf = Pdf::loadView('pdfs.ventas-diarias', compact('ventas', 'fecha', 'totalVentas', 'totalTransacciones'));
        
        return $pdf->download('ventas_diarias_' . $fecha->format('Y-m-d') . '.pdf');
    }

    /**
     * Reporte de inventario completo
     */
    public function reporteInventario()
    {
        $productos = Product::with(['category', 'supplier'])
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
        
        $totalProductos = $productos->count();
        $valorInventario = $productos->sum(function($producto) {
            return $producto->stock * $producto->price;
        });
        
        $productosBajoStock = $productos->filter(function($producto) {
            return $producto->stock <= $producto->min_stock;
        });
        
        $pdf = Pdf::loadView('pdfs.inventario', compact(
            'productos', 
            'totalProductos', 
            'valorInventario',
            'productosBajoStock'
        ));
        
        return $pdf->download('inventario_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Reporte de deudas de clientes
     */
    public function reporteDeudasClientes()
    {
        $deudas = ClientDebt::with('client')
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->get();
        
        $totalDeuda = $deudas->sum('balance_due');
        $deudasVencidas = $deudas->where('status', 'overdue');
        $totalVencido = $deudasVencidas->sum('balance_due');
        
        $pdf = Pdf::loadView('pdfs.deudas-clientes', compact(
            'deudas',
            'totalDeuda',
            'deudasVencidas',
            'totalVencido'
        ));
        
        return $pdf->download('deudas_clientes_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Reporte de historial de cliente específico
     */
    public function reporteCliente($id)
    {
        $client = Client::with(['sales', 'debts'])->findOrFail($id);
        
        $totalCompras = $client->sales->sum('total_price');
        $totalComprasCount = $client->sales->count();
        $deudaPendiente = $client->debts()
            ->whereIn('status', ['pending', 'overdue'])
            ->sum('balance_due');
        
        $pdf = Pdf::loadView('pdfs.cliente', compact(
            'client',
            'totalCompras',
            'totalComprasCount',
            'deudaPendiente'
        ));
        
        return $pdf->download('cliente_' . $client->id . '_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Reporte de productos con bajo stock
     */
    public function reporteProductosBajoStock()
    {
        $productos = Product::with(['category', 'supplier'])
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock', 'asc')
            ->get();
        
        $pdf = Pdf::loadView('pdfs.productos-bajo-stock', compact('productos'));
        
        return $pdf->download('productos_bajo_stock_' . Carbon::now()->format('Y-m-d') . '.pdf');
    }
}