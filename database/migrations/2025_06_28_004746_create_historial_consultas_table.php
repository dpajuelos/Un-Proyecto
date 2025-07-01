<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialConsultasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('historial_consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tipo_consulta');
            $table->json('detalle');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->index(['user_id', 'tipo_consulta']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_consultas');
    }
}
