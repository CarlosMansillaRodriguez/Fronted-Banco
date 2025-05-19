<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipocuenta extends Model
{
    protected $table = 'tipocuentas';

    protected $fillable = [
        'nombre'
    ];

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}
