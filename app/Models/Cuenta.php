<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $fillable = [
        'numero_cuenta',
        'tipo_cuenta',
        'saldo',
        'cliente_id',
        'moneda_id',
        'tipocuentas_id',
        'usuario_id',
        'estado',
        'fecha_apertura',
        'intereses',
        'limite_retiro_diario',
        'estado_1',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
    public function tipocuentas()
    {
        return $this->belongsTo(Tipocuenta::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
