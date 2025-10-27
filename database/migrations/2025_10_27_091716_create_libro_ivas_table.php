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
        Schema::create('libros_iva', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asiento_id')->nullable()->constrained('asientos')->nullOnDelete();
            $table->foreignId('tercero_id')->constrained('terceros')->restrictOnDelete();
            $table->enum('tipo_libro', ['Venta', 'Compra']);
            $table->date('fecha_documento');
            $table->enum('tipo_documento', ['Factura', 'Credito Fiscal', 'Nota de Credito', 'Nota de Debito']);
            $table->string('numero_documento', 100);
            $table->decimal('monto_neto', 15, 2)->default(0.00);
            $table->decimal('monto_exento', 15, 2)->default(0.00);
            $table->decimal('iva_credito_fiscal', 15, 2)->default(0.00);
            $table->decimal('iva_debito_fiscal', 15, 2)->default(0.00);
            $table->decimal('iva_percibido', 15, 2)->default(0.00);
            $table->decimal('iva_retenido', 15, 2)->default(0.00);
            $table->decimal('total_documento', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libro_ivas');
    }
};
