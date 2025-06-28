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
        Schema::create('mineras', function (Blueprint $table) {
            $table->integer('id_minera', true);
            $table->string('nombre_minera', 100);
            $table->char('ruc', 11)->unique();
            $table->string('direccion', 150)->nullable();
            $table->string('telefono_contacto', 15)->nullable();
            $table->string('correo_contacto', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mineras');
    }
};
