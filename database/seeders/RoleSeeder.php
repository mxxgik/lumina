<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['nombre_rol' => 'usuario'],
            ['nombre_rol' => 'admin'],
            ['nombre_rol' => 'portero'],
        ];

        DB::table('roles')->insert($roles);
    }
}
