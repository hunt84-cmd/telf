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
        Schema::create('telefonos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo');
            $table->enum('estado_tecnico', ['Bueno', 'Dañado', 'Roto']);
            $table->foreignId('persona_id')->nullable()->constrained()->onDelete('set null');
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
        Schema::dropIfExists('telefonos');
    }
};