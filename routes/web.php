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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::resource('editoriales', App\Http\Controllers\EditorialController::class)->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route ::resource('editoriales.update', App\Http\Controllers\EditorialController::class)->middleware('auth');

//  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
//     // ==================== PERFIL DE USUARIO ====================
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // ==================== CATEGORÍAS ====================
    // Acceso: Todos los roles autenticados
    Route::resource('categories', CategoryController::class);
    
    // ==================== PRODUCTOS ====================
    // Acceso: Almacenista y Administrador
    Route::resource('products', ProductController::class);
    
    // ==================== PROVEEDORES ====================
    // Acceso: Almacenista y Administrador
    Route::resource('suppliers', SupplierController::class);
    
    // ==================== DEUDAS DE PROVEEDORES ====================
    // Acceso: Administrador
    Route::resource('supplier_debts', SupplierDebtController::class);
    
    // ==================== CLIENTES ====================
    // Acceso: Cajero y Administrador
    Route::resource('clients', ClientController::class);
    
    // ==================== DEUDAS DE CLIENTES ====================
    // Acceso: Cajero y Administrador
    Route::resource('client_debts', ClientDebtController::class);
    
    // ==================== VENTAS ====================
    // Acceso: Cajero y Administrador
    Route::resource('sales', SaleController::class);
    
    // ==================== EMPLEADOS ====================
    // Acceso: Solo Administrador
    Route::resource('employees', EmployeeController::class);
    
    // ==================== AJUSTES DE INVENTARIO ====================
    // Acceso: Almacenista y Administrador
    Route::resource('inventory_adjustments', InventoryAdjustmentController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy']);
    
    // // ==================== GENERACIÓN DE PDFs ====================
    // Route::prefix('pdf')->name('pdf.')->group(function () {
    //     // PDF de venta individual
    //     Route::get('/venta/{id}', [PdfController::class, 'generarVenta'])->name('venta');
        
    //     // PDF de reporte de ventas diarias
    //     Route::get('/ventas-diarias', [PdfController::class, 'reporteVentasDiarias'])->name('ventas.diarias');
        
    //     // PDF de reporte de inventario
    //     Route::get('/inventario', [PdfController::class, 'reporteInventario'])->name('inventario');
        
    //     // PDF de deudas de clientes
    //     Route::get('/deudas-clientes', [PdfController::class, 'reporteDeudasClientes'])->name('deudas.clientes');
        
    //     // PDF de cliente específico
    //     Route::get('/cliente/{id}', [PdfController::class, 'reporteCliente'])->name('cliente');
        
    //     // PDF de productos con bajo stock
    //     Route::get('/productos-bajo-stock', [PdfController::class, 'reporteProductosBajoStock'])->name('productos.bajo.stock');