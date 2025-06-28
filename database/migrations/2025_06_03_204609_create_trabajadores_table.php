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
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->integer('id_trabajador', true);
            $table->char('dni', 8)->index('idx_trabajadores_dni');
            $table->integer('id_usuario')->index('idx_trabajadores_id_usuario');
            $table->integer('id_cargo')->index('idx_trabajadores_id_cargo');
            $table->integer('id_espe')->index('idx_trabajadores_id_espe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
