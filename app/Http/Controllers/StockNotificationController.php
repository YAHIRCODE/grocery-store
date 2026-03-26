<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Stocknotificationcontroller extends Controller
{
    /**
     * Enviar notificación de stock bajo manualmente
     */
    public function sendLowStockNotification()
    {
        try {
            // 1. Obtener productos con stock bajo
            $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
                ->with('category')
                ->get();

            if ($lowStockProducts->isEmpty()) {
                return redirect()
                    ->back()
                    ->with('info', 'No hay productos con stock bajo en este momento');
            }

            // 2. Obtener administradores
            $admins = User::whereHas('employee.role', function($query) {
                $query->where('name', 'Administrador');
            })->get();

            if ($admins->isEmpty()) {
                return redirect()
                    ->back()
                    ->with('error', 'No se encontraron administradores para enviar el correo');
            }

            // 3. Enviar correos
            $emailsSent = 0;
            foreach ($admins as $admin) {
                try {
                    Mail::to($admin->email)->send(
                        new LowStockNotification($lowStockProducts, $admin->name)
                    );
                    $emailsSent++;
                } catch (\Exception $e) {
                    Log::error('Error enviando correo de stock bajo', [
                        'admin' => $admin->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('Notificación de stock bajo enviada manualmente', [
                'productos' => $lowStockProducts->count(),
                'correos_enviados' => $emailsSent,
                'enviado_por' => auth()->user()->email,
            ]);

            return redirect()
                ->back()
                ->with('success', "Notificación enviada exitosamente a {$emailsSent} administrador(es). Se detectaron {$lowStockProducts->count()} productos con stock bajo.");

        } catch (\Exception $e) {
            Log::error('Error al enviar notificación de stock bajo', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al enviar la notificación: ' . $e->getMessage());
        }
    }

    /**
     * Ver productos con stock bajo
     */
public function showLowStockProducts()
    {
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->with('category')
            ->orderBy('stock', 'asc')
            ->get();

        // Agregamos un nombre por defecto para que la vista no explote
        $adminName = auth()->user()->name ?? 'Administrador';
        
        // También renombramos la variable para que coincida con el count($products) de tu vista
        $products = $lowStockProducts;

        return view('Low_stock_notification', compact('products', 'adminName'));
    }
}