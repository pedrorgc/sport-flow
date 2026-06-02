<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('espaco_id')->constrained('espacos')->onDelete('cascade');
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_fim');
            $table->enum('tipo',['Fixa','Avulsa','Oficial']);
            $table->enum('status',['Confirmada','Cancelada'])->default('Confirmada');
            $table->text('justificativa_cancelamento')->nullable();
            $table->string('grupo_reserva_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
