<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //
            $table->decimal('weight', 10, 2)->nullable();
        });
        DB::statement("ALTER TABLE sales MODIFY COLUMN sale_unit_type ENUM('unit', 'package', 'weight') DEFAULT 'unit'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            //
            $table->dropColumn(['weight']);
        });
        DB::statement("ALTER TABLE sales MODIFY COLUMN sale_unit_type ENUM('unit', 'package') DEFAULT 'unit'");
    }
};
