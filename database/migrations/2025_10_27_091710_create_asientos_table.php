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
        Schema::create('asientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('numero_asiento', 50)->unique();
            $table->text('descripcion');
            $table->enum('tipo_asiento', ['Diario', 'Apertura', 'Cierre', 'Ajuste'])->default('Diario');
            //$table->enum('estado', ['Borrador', 'Publicado', 'Anulado'])->default('Borrador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asientos');
    }
};
