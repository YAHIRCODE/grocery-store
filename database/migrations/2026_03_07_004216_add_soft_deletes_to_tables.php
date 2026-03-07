<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Agregar deleted_at a products
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a categories
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a suppliers
        Schema::table('suppliers', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a clients
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a employees
        Schema::table('employees', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a sales (opcional, normalmente NO se eliminan ventas)
        // Schema::table('sales', function (Blueprint $table) {
        //     $table->softDeletes();
        // });
        
        // Agregar deleted_at a client_debts
        Schema::table('client_debts', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        // Agregar deleted_at a supplier_debts
        Schema::table('supplier_debts', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('clients', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('employees', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('client_debts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('supplier_debts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
