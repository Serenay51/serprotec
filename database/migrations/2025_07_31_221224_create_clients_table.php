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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Nombre o Razón Social
            $table->string('email')->nullable();  // Correo
            $table->string('phone')->nullable();  // Teléfono
            $table->string('address')->nullable();// Dirección
            $table->string('cuit')->nullable();   // CUIT opcional
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
