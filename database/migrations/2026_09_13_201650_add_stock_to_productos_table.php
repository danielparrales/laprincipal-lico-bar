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
        Schema::table('productos', function (Blueprint $table) {
            // Añadimos la columna stock de tipo entero con valor por defecto 0
            $table->integer('stock')->default(0)->after('precio'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            // Si revertimos la migración, eliminamos la columna stock
            $table->dropColumn('stock');
        });
    }
};