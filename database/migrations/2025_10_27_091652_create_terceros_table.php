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
        Schema::create('terceros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nrc', 20)->nullable()->unique();
            $table->string('nit', 20)->nullable()->unique();
            $table->string('giro')->nullable();
            $table->boolean('es_cliente')->default(false);
            $table->boolean('es_proveedor')->default(false);
            $table->boolean('es_gran_contribuyente')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terceros');
    }
};
