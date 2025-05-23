<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre', 'apellido', 'ci', 'direccion', 'telefono', 'genero'];

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}
