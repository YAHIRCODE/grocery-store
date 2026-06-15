<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_funds', function (Blueprint $table) {
            $table->id();
            $table->decimal('defined_amount', 10, 2)->default(0);
            $table->decimal('extraction_limit', 10, 2)->default(0);
            $table->decimal('available_balance', 10, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_funds');
    }
};