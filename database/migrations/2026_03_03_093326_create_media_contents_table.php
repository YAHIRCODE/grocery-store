<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('media_contents', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); // Ruta del archivo en el servidor
            $table->string('file_type'); // 'image' o 'video'
            $table->string('section');   // 'carousel' o 'hero_video'
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_contents');
    }
};
