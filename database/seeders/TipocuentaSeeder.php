<?php

namespace Database\Seeders;

use App\Models\Tipocuenta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipocuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipocuenta::insert([
            [
                'nombre' => 'Cuenta ahorro'
            ],
            [
                'nombre' => 'Ceunta corriente'
            ]
        ]);
    }
}
