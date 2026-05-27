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
            $table->foreignId('modalidade_id')->constrained('modalidades')->onDelete('cascade');
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->date('prazo_inscricoes');
            $table->string('local');
            $table->text('descricao')->nullable(); 

            $table->enum('status', ['Agendado', 'Em Andamento', 'Concluído', 'Cancelado'])->default('Agendado');

            $table->timestamps();
            $table->softDeletes();
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
