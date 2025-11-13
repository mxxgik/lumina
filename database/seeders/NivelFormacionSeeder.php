<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelFormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            ['nivel_formacion' => 'Técnico'],
            ['nivel_formacion' => 'Tecnólogo'],
            ['nivel_formacion' => 'Auxiliar'],
            ['nivel_formacion' => 'Operario'],
            ['nivel_formacion' => 'Especialización Tecnológica'],
        ];

        DB::table('nivel_formacion')->insert($niveles);
    }
}