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
        Schema::table('eventos', function (Blueprint $table) {
            // 1. Cria a nova chave estrangeira
            $table->foreignId('espaco_id')->nullable()->constrained('espacos')->nullOnDelete();
            
            // 2. Apaga a coluna antiga de texto que estava dando erro
            $table->dropColumn('local');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['espaco_id']);
            $table->dropColumn('espaco_id');
            $table->string('local')->nullable();
        });
    }
};