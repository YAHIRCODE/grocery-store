<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('cash_amount', 10, 2)->default(0)->after('total_price');
            $table->decimal('card_amount', 10, 2)->default(0)->after('cash_amount');
            $table->decimal('change_amount', 10, 2)->default(0)->after('card_amount');
            $table->enum('sale_unit_type', ['unit', 'package'])->default('unit')->after('quantity');
        });

        // Modificamos el ENUM existente para incluir 'mixed'
        DB::statement("ALTER TABLE sales MODIFY COLUMN payment_method ENUM('cash', 'card', 'credit', 'mixed') DEFAULT 'cash'");
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['cash_amount', 'card_amount', 'change_amount', 'sale_unit_type']);
        });

        // Revertimos el ENUM a sus valores originales
        DB::statement("ALTER TABLE sales MODIFY COLUMN payment_method ENUM('cash', 'card', 'credit') DEFAULT 'cash'");
    }
};