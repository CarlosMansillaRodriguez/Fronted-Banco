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
            $table->id();
            $table->string('numero_cuenta')->unique();
            $table->string('estado');
            $table->date('fecha_apertura');
            $table->decimal('saldo', 100, 2);
            $table->decimal('intereses', 5, 2);
            $table->unsignedInteger('limite_retiro_diario');
            $table->tinyInteger('estado_1')->default(1);
            // Llaves foráneas
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->foreignId('tipocuentas_id')->constrained('tipocuentas');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
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
