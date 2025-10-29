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
        Schema::table('asientos', function (Blueprint $table) {
            $table->decimal('total_debe', 15, 2)
                  ->default(0.00)
                  ->before('descripcion'); // Lo pone después del concepto

            $table->decimal('total_haber', 15, 2)
                  ->default(0.00)
                  ->after('total_debe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asientos', function (Blueprint $table) {
            $table->dropColumn(['total_debe', 'total_haber']);
        });
    }
};
