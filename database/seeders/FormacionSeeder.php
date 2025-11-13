<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formaciones = [
            [
                'nivel_formacion_id' => 1,
                'ficha' => 123456,
                'nombre_programa' => 'Técnico en Sistemas',
                'fecha_inicio_programa' => '2023-01-01',
                'fecha_fin_programa' => '2024-12-31',
            ],
            [
                'nivel_formacion_id' => 2,
                'ficha' => 234567,
                'nombre_programa' => 'Tecnólogo en Desarrollo de Software',
                'fecha_inicio_programa' => '2023-01-01',
                'fecha_fin_programa' => '2025-12-31',
            ],
            [
                'nivel_formacion_id' => 3,
                'ficha' => 345678,
                'nombre_programa' => 'Auxiliar Administrativo',
                'fecha_inicio_programa' => '2023-01-01',
                'fecha_fin_programa' => '2024-06-30',
            ],
            [
                'nivel_formacion_id' => 4,
                'ficha' => 456789,
                'nombre_programa' => 'Operario de Producción',
                'fecha_inicio_programa' => '2023-01-01',
                'fecha_fin_programa' => '2024-12-31',
            ],
            [
                'nivel_formacion_id' => 5,
                'ficha' => 567890,
                'nombre_programa' => 'Especialización en Ciberseguridad',
                'fecha_inicio_programa' => '2023-01-01',
                'fecha_fin_programa' => '2024-12-31',
            ],
        ];

        DB::table('formacion')->insert($formaciones);
    }
}