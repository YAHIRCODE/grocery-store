<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla principal de la nota
        Schema::create('supplier_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->enum('status', ['pending', 'confirmed', 'paid'])->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->date('delivery_date')->nullable();
            $table->string('anticipated_ticket_path')->nullable();
            $table->string('delivery_ticket_path')->nullable();
            $table->text('reminders')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('confirmed_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });

        // Tabla pivote para los productos de esa nota
        Schema::create('supplier_note_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_note_id')->constrained('supplier_notes')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('quantity_agreed');
            $table->integer('quantity_received')->nullable();
            $table->decimal('price_agreed', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->boolean('is_gift')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_note_details');
        Schema::dropIfExists('supplier_notes');
    }
};
