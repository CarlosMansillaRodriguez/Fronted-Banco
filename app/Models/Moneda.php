<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $table = 'monedas';

    protected $fillable = [
        'nombre'
    ];

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}
