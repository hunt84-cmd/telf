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
        Schema::create('lineas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_telefono')->unique();
            $table->string('pin');
            $table->string('puk');
            $table->foreignId('persona_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('paquete_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('estado', ['Activa', 'Inactiva', 'Suspendida'])->default('Inactiva');
            $table->timestamp('fecha_ingreso_almacen')->useCurrent();
            $table->timestamp('fecha_asignacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineas');
    }
};