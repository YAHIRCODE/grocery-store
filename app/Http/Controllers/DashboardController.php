<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Client;
use App\Models\ClientDebt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas para el dashboard
        $ventasHoy = Sale::whereDate('created_at', Carbon::today())->count();
        $ventasHoyTotal = Sale::whereDate('created_at', Carbon::today())->sum('total_price');
        
        $productosConBajoStock = Product::whereColumn('stock', '<=', 'min_stock')->count();
        
        $deudasPendientes = ClientDebt::whereIn('status', ['pending', 'overdue'])->sum('balance_due');
        
        $clientesActivos = Client::count();
        
        // Últimas 5 ventas
        $ultimasVentas = Sale::with(['product', 'employee'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact(
            'ventasHoy',
            'ventasHoyTotal',
            'productosConBajoStock',
            'deudasPendientes',
            'clientesActivos',
            'ultimasVentas'
        ));
    }
    
    public function reporteVentas()
    {
        $ventas = Sale::with(['product', 'employee', 'client'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('reportes.ventas', compact('ventas'));
    }
    
    public function reporteProductos()
    {
        $productos = Product::with('category')
            ->orderBy('stock', 'asc')
            ->get();
        
        return view('reportes.productos', compact('productos'));
    }
    
    public function reporteClientes()
    {
        $clientes = Client::withCount('debts')
            ->with('debts')
            ->get();
        
        return view('reportes.clientes', compact('clientes'));
    }
    
    public function reporteDeudas()
    {
        $deudasClientes = ClientDebt::with('client')
            ->whereIn('status', ['pending', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->get();
        
        return view('reportes.deudas', compact('deudasClientes'));
    }
}