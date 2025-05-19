<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            //Clientes
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',
            //Cuentas
            'ver-cuenta',
            'crear-cuenta',
            'editar-cuenta',
            'eliminar-cuenta',
            //Transacciones
            'ver-transaccion',
            'crear-transaccion',
            'editar-transaccion',
            'eliminar-transaccion',
            //Bitacora
            'ver-bitacora',
            //reportes
            'ver-reporte',
            'crear-reporte',
            'eliminar-reporte',
        ];
        foreach($permisos as $persmiso){
            Permission::create(['name' => $persmiso]);
        }
    }
}
