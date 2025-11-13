<?php

namespace Database\Seeders;

use App\Models\ElementoAdicional;
use App\Models\EquipoOElemento;
use App\Models\Formacion;
use App\Models\Historial;
use App\Models\NivelFormacion;
use App\Models\User;
use App\Models\UsuarioEquipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
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

        Historial::factory(50)->create();

        // Assign each user with 'usuario' role to one equipo
        $users = User::where('role_id', 1)->get(); // Only users with role 'usuario'
        $equipos = EquipoOElemento::all();
        $users->each(function ($user, $index) use ($equipos) {
            // Assign to equipo at same index if available, cycle if necessary
            $equipoIndex = $index % $equipos->count();
            UsuarioEquipo::create([
                'usuario_id' => $user->id,
                'equipos_o_elementos_id' => $equipos[$equipoIndex]->id,
            ]);
        });

        EquipoOElemento::all()->each(function ($equipo){
            ElementoAdicional::factory(rand(1,3))->create(['equipos_o_elementos_id'=> $equipo->id]);
        });

    }
}
