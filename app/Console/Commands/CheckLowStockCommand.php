<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckLowStockCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stock:check-low';

    /**
     * The console command description.
     */
    protected $description = 'Verifica productos con stock bajo y envía notificación por correo';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Verificando productos con stock bajo...');

        // Obtener productos con stock bajo o agotado
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')
            ->with('category')
            ->get();

        if ($lowStockProducts->isEmpty()) {
            $this->info('✅ No hay productos con stock bajo');
            return Command::SUCCESS;
        }

        $this->warn("⚠️  Encontrados {$lowStockProducts->count()} productos con stock bajo:");

        // Mostrar en consola
        foreach ($lowStockProducts as $product) {
            $status = $product->stock == 0 ? 'AGOTADO' : 'BAJO';
            $this->line("   - {$product->name}: {$product->stock}/{$product->min_stock} unidades [{$status}]");
        }

        // Obtener administradores
        $admins = User::whereHas('employee.role', function($query) {
            $query->where('name', 'Administrador');
        })->get();

        if ($admins->isEmpty()) {
            $this->error('❌ No se encontraron administradores para enviar el correo');
            return Command::FAILURE;
        }

        // Enviar correo a cada administrador
        $emailsSent = 0;
        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(
                    new LowStockNotification($lowStockProducts, $admin->name)
                );
                $emailsSent++;
                $this->info("   ✉️  Correo enviado a: {$admin->email}");
            } catch (\Exception $e) {
                $this->error("   ❌ Error al enviar a {$admin->email}: {$e->getMessage()}");
                Log::error('Error enviando correo de stock bajo', [
                    'admin' => $admin->email,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info("\n📧 Total de correos enviados: {$emailsSent}");

        Log::info('Verificación de stock bajo completada', [
            'productos_bajo_stock' => $lowStockProducts->count(),
            'correos_enviados' => $emailsSent
        ]);

        return Command::SUCCESS;
    }
}