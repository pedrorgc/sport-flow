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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('modalidade', ['Futebol','Futsal', 'Vôlei', 'Basquete'])-> default('Futebol');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('prazo_inscricoes');
            $table->string('local');
            $table->enum('status', ['Planejado', 'Em Andamento', 'Finalizado', 'Cancelado'])->default('Planejado');
            $table->string('descrição');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
