<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDebtController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierDebtController;
use App\Http\Controllers\InventoryAdjustmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas Autenticadas con Control de Roles
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ==================== PERFIL ====================
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ==================== CATEGORÍAS ====================
    // Ver: Todos
// 1. Primero la ruta de crear
Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');

// 2. Después la ruta con parámetro
Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// La de index puede ir en cualquier lugar, pero usualmente va al inicio
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    
    // Crear/Editar: Solo Almacenista y Admin
    Route::middleware(['role:Almacenista,Administrador'])->group(function () {
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    
    // ==================== PRODUCTOS ====================
    // Solo Almacenista y Admin
    Route::middleware(['role:Almacenista,Administrador'])->group(function () {
        Route::resource('products', ProductController::class);
    });
    
    // ==================== PROVEEDORES ====================
    // Solo Almacenista y Admin
    Route::middleware(['role:Almacenista,Administrador'])->group(function () {
        Route::resource('suppliers', SupplierController::class);
    });
    
    // ==================== AJUSTES DE INVENTARIO ====================
    // Solo Almacenista y Admin
    Route::middleware(['role:Almacenista,Administrador'])->group(function () {
        Route::resource('inventory_adjustments', InventoryAdjustmentController::class)
            ->only(['index', 'create', 'store', 'show', 'destroy']);
    });
    
    // ==================== VENTAS ====================
    // Solo Cajero y Admin
    Route::middleware(['role:Cajero,Administrador'])->group(function () {
        Route::resource('sales', SaleController::class);
    });
    
    // ==================== CLIENTES ====================
    // Solo Cajero y Admin
    Route::middleware(['role:Cajero,Administrador'])->group(function () {
        Route::resource('clients', ClientController::class);
    });
    
    // ==================== DEUDAS DE CLIENTES ====================
    // Solo Cajero y Admin
    Route::middleware(['role:Cajero,Administrador'])->group(function () {
        Route::resource('client_debts', ClientDebtController::class);
    });
    
    // ==================== DEUDAS DE PROVEEDORES ====================
    // Solo Administrador
    Route::middleware(['role:Administrador'])->group(function () {
        Route::resource('supplier_debts', SupplierDebtController::class);
    });
    
    // ==================== EMPLEADOS ====================
    // Solo Administrador
    Route::middleware(['role:Administrador'])->group(function () {
        Route::resource('employees', EmployeeController::class);
    });
    
    // ==================== PDFs ====================
    Route::prefix('pdf')->name('pdf.')->group(function () {
        // Todos pueden generar PDF de venta
        Route::get('/venta/{id}', [PdfController::class, 'generarVenta'])->name('venta');
        
        // Solo Admin para reportes generales
        Route::middleware(['role:Administrador'])->group(function () {
            Route::get('/ventas-diarias', [PdfController::class, 'reporteVentasDiarias'])->name('ventas.diarias');
            Route::get('/inventario', [PdfController::class, 'reporteInventario'])->name('inventario');
            Route::get('/deudas-clientes', [PdfController::class, 'reporteDeudasClientes'])->name('deudas.clientes');
            Route::get('/productos-bajo-stock', [PdfController::class, 'reporteProductosBajoStock'])->name('productos.bajo.stock');
        });
        
        // Cajero y Admin para cliente específico
        Route::middleware(['role:Cajero,Administrador'])->group(function () {
            Route::get('/cliente/{id}', [PdfController::class, 'reporteCliente'])->name('cliente');
        });
    });
    
    // ==================== REPORTES HTML ====================
    // Solo Administrador
    Route::middleware(['role:Administrador'])->prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/ventas', [DashboardController::class, 'reporteVentas'])->name('ventas');
        Route::get('/productos', [DashboardController::class, 'reporteProductos'])->name('productos');
        Route::get('/clientes', [DashboardController::class, 'reporteClientes'])->name('clientes');
        Route::get('/deudas', [DashboardController::class, 'reporteDeudas'])->name('deudas');
    });
});

