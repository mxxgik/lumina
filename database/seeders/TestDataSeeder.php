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

        // Additional porters
        User::create([
            'role_id' => 3,
            'formacion_id' => null,
            'nombre' => 'Jorge',
            'apellido' => 'López',
            'tipo_documento' => 'CC',
            'documento' => '1012345680',
            'edad' => 45,
            'numero_telefono' => '3001234569',
            'path_foto' => '/storage/fotos/portero1.jpg',
            'email' => 'jorge.lopez@lumina.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 3,
            'formacion_id' => null,
            'nombre' => 'Ana',
            'apellido' => 'García',
            'tipo_documento' => 'CC',
            'documento' => '1012345681',
            'edad' => 38,
            'numero_telefono' => '3001234570',
            'path_foto' => '/storage/fotos/portero2.jpg',
            'email' => 'ana.garcia@lumina.edu.co',
            'password' => Hash::make('password'),
        ]);

        // Additional users
        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'tipo_documento' => 'CC',
            'documento' => '1023456789',
            'edad' => 22,
            'numero_telefono' => '3101234567',
            'path_foto' => '/storage/fotos/usuario1.jpg',
            'email' => 'juan.perez@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Sofía',
            'apellido' => 'Hernández',
            'tipo_documento' => 'CC',
            'documento' => '1023456790',
            'edad' => 21,
            'numero_telefono' => '3101234568',
            'path_foto' => '/storage/fotos/usuario2.jpg',
            'email' => 'sofia.hernandez@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Diego',
            'apellido' => 'Ramírez',
            'tipo_documento' => 'CC',
            'documento' => '1023456791',
            'edad' => 23,
            'numero_telefono' => '3101234569',
            'path_foto' => '/storage/fotos/usuario3.jpg',
            'email' => 'diego.ramirez@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Valentina',
            'apellido' => 'Torres',
            'tipo_documento' => 'CC',
            'documento' => '1023456792',
            'edad' => 20,
            'numero_telefono' => '3101234570',
            'path_foto' => '/storage/fotos/usuario4.jpg',
            'email' => 'valentina.torres@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Andrés',
            'apellido' => 'Gómez',
            'tipo_documento' => 'CC',
            'documento' => '1023456793',
            'edad' => 24,
            'numero_telefono' => '3101234571',
            'path_foto' => '/storage/fotos/usuario5.jpg',
            'email' => 'andres.gomez@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'role_id' => 1,
            'formacion_id' => null,
            'nombre' => 'Camila',
            'apellido' => 'Morales',
            'tipo_documento' => 'CC',
            'documento' => '1023456794',
            'edad' => 22,
            'numero_telefono' => '3101234572',
            'path_foto' => '/storage/fotos/usuario6.jpg',
            'email' => 'camila.morales@aprendiz.edu.co',
            'password' => Hash::make('password'),
        ]);

        // Equipos o Elementos
        EquipoOElemento::create([
            'id' => 1,
            'sn_equipo' => 'LAP001HP2024',
            'marca' => 'HP',
            'color' => 'Negro',
            'tipo_elemento' => 'Laptop',
            'descripcion' => 'HP Pavilion 15, Intel i5, 8GB RAM, 256GB SSD',
            'qr_hash' => 'QR001HP2024LAP',
            'path_foto_equipo_implemento' => '/storage/equipos/laptop_hp_1.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 2,
            'sn_equipo' => 'LAP002DL2024',
            'marca' => 'Dell',
            'color' => 'Plata',
            'tipo_elemento' => 'Laptop',
            'descripcion' => 'Dell Inspiron 14, Intel i7, 16GB RAM, 512GB SSD',
            'qr_hash' => 'QR002DL2024LAP',
            'path_foto_equipo_implemento' => '/storage/equipos/laptop_dell_2.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 3,
            'sn_equipo' => 'LAP003LN2024',
            'marca' => 'Lenovo',
            'color' => 'Negro',
            'tipo_elemento' => 'Laptop',
            'descripcion' => 'Lenovo ThinkPad, Intel i5, 8GB RAM, 256GB SSD',
            'qr_hash' => 'QR003LN2024LAP',
            'path_foto_equipo_implemento' => '/storage/equipos/laptop_lenovo_3.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 4,
            'sn_equipo' => 'LAP004AC2024',
            'marca' => 'Acer',
            'color' => 'Azul',
            'tipo_elemento' => 'Laptop',
            'descripcion' => 'Acer Aspire 5, AMD Ryzen 5, 12GB RAM, 512GB SSD',
            'qr_hash' => 'QR004AC2024LAP',
            'path_foto_equipo_implemento' => '/storage/equipos/laptop_acer_4.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 5,
            'sn_equipo' => 'LAP005AS2024',
            'marca' => 'Asus',
            'color' => 'Gris',
            'tipo_elemento' => 'Laptop',
            'descripcion' => 'Asus VivoBook, Intel i3, 8GB RAM, 256GB SSD',
            'qr_hash' => 'QR005AS2024LAP',
            'path_foto_equipo_implemento' => '/storage/equipos/laptop_asus_5.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 6,
            'sn_equipo' => 'TAB001SM2024',
            'marca' => 'Samsung',
            'color' => 'Negro',
            'tipo_elemento' => 'Tablet',
            'descripcion' => 'Samsung Galaxy Tab S7, 128GB, WiFi',
            'qr_hash' => 'QR006SM2024TAB',
            'path_foto_equipo_implemento' => '/storage/equipos/tablet_samsung_6.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 7,
            'sn_equipo' => 'TAB002AP2024',
            'marca' => 'Apple',
            'color' => 'Plata',
            'tipo_elemento' => 'Tablet',
            'descripcion' => 'iPad Air 10.9, 256GB, WiFi',
            'qr_hash' => 'QR007AP2024TAB',
            'path_foto_equipo_implemento' => '/storage/equipos/tablet_apple_7.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 8,
            'sn_equipo' => 'PRO001LG2024',
            'marca' => 'LG',
            'color' => 'Negro',
            'tipo_elemento' => 'Proyector',
            'descripcion' => 'Proyector LG Full HD, 3000 lúmenes',
            'qr_hash' => 'QR008LG2024PRO',
            'path_foto_equipo_implemento' => '/storage/equipos/proyector_lg_8.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 9,
            'sn_equipo' => 'ROU001TP2024',
            'marca' => 'TP-Link',
            'color' => 'Blanco',
            'tipo_elemento' => 'Router',
            'descripcion' => 'Router TP-Link AC1750, Dual Band',
            'qr_hash' => 'QR009TP2024ROU',
            'path_foto_equipo_implemento' => '/storage/equipos/router_tplink_9.jpg',
        ]);

        EquipoOElemento::create([
            'id' => 10,
            'sn_equipo' => 'MON001SM2024',
            'marca' => 'Samsung',
            'color' => 'Negro',
            'tipo_elemento' => 'Monitor',
            'descripcion' => 'Monitor Samsung 24 pulgadas Full HD',
            'qr_hash' => 'QR010SM2024MON',
            'path_foto_equipo_implemento' => '/storage/equipos/monitor_samsung_10.jpg',
        ]);

        // Elementos Adicionales
        ElementoAdicional::create([
            'id' => 1,
            'nombre_elemento' => 'Cargador HP Original 65W',
            'path_foto_elemento' => '/storage/elementos/cargador_hp_1.jpg',
            'equipos_o_elementos_id' => 1,
        ]);

        ElementoAdicional::create([
            'id' => 2,
            'nombre_elemento' => 'Mouse Inalámbrico Logitech',
            'path_foto_elemento' => '/storage/elementos/mouse_logitech_1.jpg',
            'equipos_o_elementos_id' => 1,
        ]);

        ElementoAdicional::create([
            'id' => 3,
            'nombre_elemento' => 'Cargador Dell Original 90W',
            'path_foto_elemento' => '/storage/elementos/cargador_dell_2.jpg',
            'equipos_o_elementos_id' => 2,
        ]);

        ElementoAdicional::create([
            'id' => 4,
            'nombre_elemento' => 'Base Refrigerante para Laptop',
            'path_foto_elemento' => '/storage/elementos/base_refrigerante_2.jpg',
            'equipos_o_elementos_id' => 2,
        ]);

        ElementoAdicional::create([
            'id' => 5,
            'nombre_elemento' => 'Cargador Lenovo Original 65W',
            'path_foto_elemento' => '/storage/elementos/cargador_lenovo_3.jpg',
            'equipos_o_elementos_id' => 3,
        ]);

        ElementoAdicional::create([
            'id' => 6,
            'nombre_elemento' => 'Maletín para Laptop 15.6"',
            'path_foto_elemento' => '/storage/elementos/maletin_3.jpg',
            'equipos_o_elementos_id' => 3,
        ]);

        ElementoAdicional::create([
            'id' => 7,
            'nombre_elemento' => 'Cargador Acer Original 65W',
            'path_foto_elemento' => '/storage/elementos/cargador_acer_4.jpg',
            'equipos_o_elementos_id' => 4,
        ]);

        ElementoAdicional::create([
            'id' => 8,
            'nombre_elemento' => 'Teclado USB Externo',
            'path_foto_elemento' => '/storage/elementos/teclado_usb_4.jpg',
            'equipos_o_elementos_id' => 4,
        ]);

        ElementoAdicional::create([
            'id' => 9,
            'nombre_elemento' => 'Cargador Samsung Tablet',
            'path_foto_elemento' => '/storage/elementos/cargador_samsung_6.jpg',
            'equipos_o_elementos_id' => 6,
        ]);

        ElementoAdicional::create([
            'id' => 10,
            'nombre_elemento' => 'Cable HDMI 2.0 - 2 metros',
            'path_foto_elemento' => '/storage/elementos/cable_hdmi_8.jpg',
            'equipos_o_elementos_id' => 8,
        ]);

        // Usuario Equipos
        UsuarioEquipo::create([
            'id' => 1,
            'usuario_id' => 5,
            'equipos_o_elementos_id' => 1,
        ]);

        UsuarioEquipo::create([
            'id' => 2,
            'usuario_id' => 5,
            'equipos_o_elementos_id' => 6,
        ]);

        UsuarioEquipo::create([
            'id' => 3,
            'usuario_id' => 6,
            'equipos_o_elementos_id' => 2,
        ]);

        UsuarioEquipo::create([
            'id' => 4,
            'usuario_id' => 7,
            'equipos_o_elementos_id' => 3,
        ]);

        UsuarioEquipo::create([
            'id' => 5,
            'usuario_id' => 7,
            'equipos_o_elementos_id' => 10,
        ]);

        UsuarioEquipo::create([
            'id' => 6,
            'usuario_id' => 8,
            'equipos_o_elementos_id' => 4,
        ]);

        UsuarioEquipo::create([
            'id' => 7,
            'usuario_id' => 9,
            'equipos_o_elementos_id' => 5,
        ]);

        UsuarioEquipo::create([
            'id' => 8,
            'usuario_id' => 9,
            'equipos_o_elementos_id' => 8,
        ]);

        UsuarioEquipo::create([
            'id' => 9,
            'usuario_id' => 10,
            'equipos_o_elementos_id' => 7,
        ]);

        UsuarioEquipo::create([
            'id' => 10,
            'usuario_id' => 10,
            'equipos_o_elementos_id' => 9,
        ]);

        // Historial
        Historial::create([
            'id' => 1,
            'usuario_id' => 5,
            'equipos_o_elementos_id' => 1,
            'ingreso' => '2024-11-11 07:30:00',
            'salida' => '2024-11-11 17:45:00',
        ]);

        Historial::create([
            'id' => 2,
            'usuario_id' => 6,
            'equipos_o_elementos_id' => 2,
            'ingreso' => '2024-11-11 08:00:00',
            'salida' => '2024-11-11 16:30:00',
        ]);

        Historial::create([
            'id' => 3,
            'usuario_id' => 7,
            'equipos_o_elementos_id' => 3,
            'ingreso' => '2024-11-11 07:45:00',
            'salida' => '2024-11-11 18:00:00',
        ]);

        Historial::create([
            'id' => 4,
            'usuario_id' => 8,
            'equipos_o_elementos_id' => 4,
            'ingreso' => '2024-11-11 08:15:00',
            'salida' => '2024-11-11 17:00:00',
        ]);

        Historial::create([
            'id' => 5,
            'usuario_id' => 9,
            'equipos_o_elementos_id' => 5,
            'ingreso' => '2024-11-11 07:50:00',
            'salida' => '2024-11-11 17:30:00',
        ]);

        Historial::create([
            'id' => 6,
            'usuario_id' => 5,
            'equipos_o_elementos_id' => 1,
            'ingreso' => '2024-11-12 07:35:00',
            'salida' => null,
        ]);

        Historial::create([
            'id' => 7,
            'usuario_id' => 6,
            'equipos_o_elementos_id' => 2,
            'ingreso' => '2024-11-12 08:05:00',
            'salida' => null,
        ]);

        Historial::create([
            'id' => 8,
            'usuario_id' => 7,
            'equipos_o_elementos_id' => 3,
            'ingreso' => '2024-11-12 07:40:00',
            'salida' => null,
        ]);

        Historial::create([
            'id' => 9,
            'usuario_id' => 10,
            'equipos_o_elementos_id' => 7,
            'ingreso' => '2024-11-12 08:20:00',
            'salida' => null,
        ]);

        Historial::create([
            'id' => 10,
            'usuario_id' => 9,
            'equipos_o_elementos_id' => 8,
            'ingreso' => '2024-11-12 07:55:00',
            'salida' => null,
        ]);
    }
}
