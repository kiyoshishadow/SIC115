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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id(); // Es BIGINT UNSIGNED AUTO_INCREMENT
            $table->foreignId('padre_id')->nullable()->constrained('cuentas')->nullOnDelete();
            $table->string('codigo', 50)->unique();
            $table->string('nombre');
            $table->enum('tipo', ['Activo', 'Pasivo', 'Patrimonio', 'Ingreso', 'Costo', 'Gasto']);
            $table->enum('naturaleza', ['Deudor', 'Acreedor']);
            $table->boolean('permite_movimientos')->default(false);
            $table->decimal('saldo_actual', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};
