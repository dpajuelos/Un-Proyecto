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
        Schema::create('citas', function (Blueprint $table) {
            $table->integer('id_cita', true);
            $table->integer('id_rep')->index('idx_citas_id_rep');
            $table->integer('id_rep_sus')->nullable()->index('idx_citas_id_rep_sus');
            $table->date('fecha')->index('idx_citas_fecha');
            $table->time('hora');
            $table->date('fecha_nue')->nullable();
            $table->time('hora_nue')->nullable();
            $table->string('estado', 20)->nullable()->default('Pendiente')->index('idx_citas_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
