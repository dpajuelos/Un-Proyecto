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
        Schema::create('trabajador_turno', function (Blueprint $table) {
            $table->integer('id_trabajador');
            $table->integer('id_turno')->index('id_turno');

            $table->primary(['id_trabajador', 'id_turno']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajador_turno');
    }
};
