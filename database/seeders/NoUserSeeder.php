<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ElementoAdicional;
use App\Models\EquipoOElemento;
use App\Models\Formacion;
use App\Models\Historial;
use App\Models\NivelFormacion;
use App\Models\User;
use App\Models\UsuarioEquipo;
use Illuminate\Support\Facades\Hash;

class NoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(NivelFormacionSeeder::class);
        $this->call(FormacionSeeder::class);
        $this->call(RoleSeeder::class);

        User::create([
            'role_id' => 2,
            'formacion_id' => null,
            'nombre' => 'Admin',
            'apellido' => 'Admin',
            'tipo_documento' => null,
            'documento' => null,
            'edad' => null,
            'numero_telefono' => null,
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin12345'),
        ]);

        User::create([
            'role_id' => 3,
            'formacion_id' => null,
            'nombre' => 'Celador',
            'apellido' => 'Celador',
            'tipo_documento' => null,
            'documento' => null,
            'edad' => null,
            'numero_telefono' => null,
            'email' => 'celador@celador.com',
            'password' => Hash::make('celador12345'),
        ]);
    }
}
