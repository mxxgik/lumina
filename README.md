# Lumina

<p align="center"><a target="_blank"><img src="lumina-logo.png" width="400" alt="Lumina Logo"></a></p>

## ¿Que es Lumina?

Lumina es una API REST basada en Laravel diseñada para gestionar equipos, usuarios, programas de formación y control de acceso en un entorno educativo o de formación. El sistema soporta control de acceso basado en roles con tres roles principales: admin, portero (portero/guardia) y usuario (usuario/aprendiz).

### Caracteristicas

- **Manejo de Usuarios**: Registro, autenticacion, manejo de perfiles.
- **Manejo de Equipos**: Seguimiento de equipos y elementos con codigos QR.
- **Manejo de Formaciones**: Manejo de formaciones y sus niveles.
- **Control de Acceso**: Permisos basados en roles y registro de entrada/salida de equipos.
- **Manejo de Imagenes**: Almacenamiento y acceso seguro de imagenes.
- **Recuperacion de Contraseña (Aplicacion Mobil)**: Recuperacion de contraseña basada en correo electronico.

### Tech Stack

- **Framework**: Laravel 11.x
- **Base de Datos**: PostgreSQL
- **Autenticacion**: Sanctum (Modo de Tokens)
- **Comunicacion en Tiempo Real**: Laravel Broadcasting con Pusher como Backend
- **Almacenamiento**: Almacenamiento en el servidor

## Autenticación

La API utiliza Laravel Sanctum para la autenticacion. Todos los endpoints protegidos requieren un Bearer Token en el Authorization header.

### Roles y Permisos

1. **Admin**: Acceso completo a todos los endpoints .
2. **Portero**: Acceso de solo lectura a la mayoria de los datos, puede registrar entradas/salidas de equipos.
3. **Usuario**: Acceso unicamente a sus propios datos y equipos asignados.

## Endpoints de la API

### Rutas de Autenticacion

#### POST /api/auth/login (Publica)
Login del usuario, retorna token de acceso e informacion del usuario.

**Cuerpo de la Peticion:**
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

**Respuesta (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "email": "user@example.com",
      "nombre": "John",
      "apellido": "Doe",
      "role": {...},
      "formacion": {...}
    },
    "token": "bearer_token_here",
    "token_type": "Bearer"
  }
}
```

#### POST /api/auth/logout (Requiere Autenticacion)
Logout del Usuario.

**Respuesta (200):**
```json
{
  "success": true,
  "message": "Logged out successfully"
}
```

### Recuperacion de Contraseña (Publico)

#### POST /api/password/forgot
Envía un código para resetear la contraseña al correo.

**Cuerpo de la Peticion:**
```json
{
  "email": "user@example.com"
}
```

**Respuesta (200):**
```json
{
  "success": true,
  "message": "Si el correo existe, se ha enviado un código de recuperación."
}
```

#### POST /api/password/verify-code
Verifica el codigo de recuperacion y retorna un token de reseteo.

**Cuerpo de la Peticion:**
```json
{
  "email": "user@example.com",
  "code": "123456"
}
```

**Respuesta (200):**
```json
{
  "success": true,
  "message": "Código verificado correctamente",
  "data": {
    "reset_token": "reset_token_here"
  }
}
```

#### POST /api/password/reset
Resetea la contraseña usando el token de reseteo.

**Cuerpo de la Peticion:**
```json
{
  "email": "user@example.com",
  "reset_token": "reset_token_here",
  "password": "newpassword123",
  "password_confirmation": "newpassword123"
}
```

**Respuesta (200):**
```json
{
  "success": true,
  "message": "Contraseña actualizada correctamente. Por favor, inicia sesión con tu nueva contraseña."
}
```

### Rutas para Admin (Requiere rol de 'admin')

#### POST /api/admin/register
Registra un nuevo Usuario.

**Cuerpo de la Peticion:**
```json
{
  "email": "newuser@example.com",
  "password": "password123",
  "role_id": 1,
  "formacion_id": 1,
  "nombre": "Jane",
  "apellido": "Smith",
  "tipo_documento": "CC",
  "documento": "123456789",
  "edad": 25,
  "numero_telefono": "+1234567890",
  "path_foto": "file (image)"
}
```

**Respuesta (201):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {...},
    "token": "bearer_token",
    "token_type": "Bearer"
  }
}
```

#### Rutas generales para Admin

Todas las operaciones estandar CRUD para los siguientes recursos:

- **Usuarios**: `/api/admin/users` (a excepcion del los otros endpoints, este no soporta POST, el endpoint de registro/creacion de usuarios es `/api/admin/register`)
- **Elementos Adicionales**: `/api/admin/elementos-adicionales`
- **Equipos/Elementos**: `/api/admin/equipos-elementos`
- **Formaciones**: `/api/admin/formaciones`
- **Historial**: `/api/admin/historial`
- **Niveles de Formación**: `/api/admin/tipos-programa`

Cada recurso soporta:
- GET `/` - Listar todos
- POST `/` - Crear nuevo
- GET `/{id}` - Mostrar especifico
- PUT/PATCH `/{id}` - Actualizar especifico
- DELETE `/{id}` - Eliminar especifico


##### Crear Equipo/Elemento (POST /api/admin/equipos-elementos)
**Cuerpo de la Peticion:**
```json
{
  "sn_equipo": "SN123456",
  "tipo_elemento": "Computador",
  "marca": "Dell",
  "color": "Negro",
  "descripcion": "Computador portatil",
  "path_foto_equipo_implemento": "file (image)"
}
```

##### Crear Formación (POST /api/admin/formaciones)
**Cuerpo de la Peticion:**
```json
{
  "nivel_formacion_id": 1,
  "ficha": "123456",
  "nombre_programa": "Tecnico en Sistemas",
  "fecha_inicio_programa": "2024-01-15",
  "fecha_fin_programa": "2024-12-15"
}
```

##### Crear Elemento Adicional (POST /api/admin/elementos-adicionales)
**Cuerpo de la Peticion:**
```json
{
  "nombre_elemento": "Mouse",
  "equipos_o_elementos_id": 1
}
```

##### Crear Nivel de Formación (POST /api/admin/tipos-programa)
**Cuerpo de la Peticion:**
```json
{
  "nivel_formacion": "Tecnico"
}
```

##### Crear Historial (POST /api/admin/historial)
**Cuerpo de la Peticion:**
```json
{
  "usuario_id": 1,
  "equipos_o_elementos_id": 1,
  "ingreso": "2024-01-15 08:00:00",
  "salida": "2024-01-15 17:00:00"
}
```

##### Crear Usuario-Equipo (POST /api/admin/usuario-equipos)
**Cuerpo de la Peticion:**
```json
{
  "usuario_id": 1,
  "equipos_o_elementos_id": 1
}
```

##### Asignaciones de Elementos Adicionales

- GET `/api/admin/equipos-elementos/asignaciones` - Listar todas las asignaciones
- GET `/api/admin/equipos-elementos/asignaciones/{equipoId}` - Obtener asignaciones de un equipo específico
- POST `/api/admin/equipos-elementos/asignar-elementos` - Asignar elementos adicionales a un equipo
- POST `/api/admin/equipos-elementos/quitar-elementos` - Quitar elementos adicionales de un equipo

**Asignar Elementos Adicionales (POST /api/admin/equipos-elementos/asignar-elementos)**
**Cuerpo de la Peticion:**
```json
{
  "equipos_o_elementos_id": 1,
  "elementos_adicionales_ids": [1, 2, 3]
}
```

**Quitar Elementos Adicionales (POST /api/admin/equipos-elementos/quitar-elementos)**
**Cuerpo de la Peticion:**
```json
{
  "equipos_o_elementos_id": 1,
  "elementos_adicionales_ids": [1, 2]
}
```

### Rutas para Portero (Requiere rol de 'portero')

#### GET /api/portero/aprendices
Lista todos los aprendices (usuarios con rol 'aprendiz').

**Respuesta (200):**
```json
{
  "success": true,
  "data": [...]
}
```

#### GET /api/portero/aprendices/{id}
Obtiene un aprendiz especifico por ID.

#### POST /api/portero/aprendices
Obtiene un aprendiz por numero de identificacion.

**Cuerpo de la Peticion:**
```json
{
  "id": 123
}
```

#### Rutas Equipos o Elementos y Elementos Adicionales (Solo Lectura para Portero)

- GET `/api/portero/elementos-adicionales`
- GET `/api/portero/elementos-adicionales/{id}`
- GET `/api/portero/equipos-elementos`
- GET `/api/portero/equipos-elementos/{id}`
- POST `/api/portero/equipos-elementos` (Se Obtiene por el hash QR)

**Cuerpo de la Peticion:**
```json
{
  "hash": "qr_hash_value"
}
```

**Respuesta (200):**
```json
{
  "success": true,
  "data": {...}
}
```

- GET `/api/portero/aprendices-equipos`
- GET `/api/portero/aprendices-equipos/{id}`
- GET `/api/portero/usuario-equipos`

#### Rutas para Formaciones y Tipos de Programa (Solo Lectura para Portero)

- GET `/api/portero/formaciones`
- GET `/api/portero/formaciones/{id}`
- GET `/api/portero/tipos-programa`
- GET `/api/portero/tipos-programa/{id}`

#### Rutas para Historial

- GET `/api/portero/historial`
- GET `/api/portero/historial/{id}`
- POST `/api/portero/historial` (Registrar Entrada o Salida)

**Request para Registrar Entrada o Salida:**
```json
{
  "usuario_id": 1,
  "equipos_o_elementos_id": 1,
  "datetime": "2023-10-01 08:00:00"
}
```

### Rutas de Usuario (Requiere rol de 'usuario')

#### GET /api/usuario/profile
Obtener el perfil del usuario autenticado.

#### Rutas de Equipos

- GET `/api/usuario/equipos` - Equipos asignados al usuario
- GET `/api/usuario/equipos/{id}` - Detalles de equipo específico

#### Rutas de Historial

- GET `/api/usuario/historial` - Historial de equipos del usuario
- GET `/api/usuario/historial/{id}` - Entrada específica del historial

#### Rutas de Formación

- GET `/api/usuario/formaciones` - Programas de formación del usuario
- GET `/api/usuario/formaciones/{id}` - Detalles de formación específica

### Rutas de Imágenes (Usuarios autenticados)

#### GET /api/images/{filename}
Recuperar archivo de imagen (equipos o fotos de usuario).

## Canales de Transmisión

### App.Models.User.{id}
Canal privado para eventos específicos del usuario.

**Autorización:** El usuario debe ser propietario del canal (ID coincide con el usuario autenticado).

### historial-updates
Canal público para actualizaciones de historial.

**Autorización:** Siempre verdadero (público).

## Documentación de Controladores

### AuthController

Maneja la autenticación de usuarios, registro y gestión de tokens.

**Métodos:**
- `register(Request $request)`: Registrar nuevo usuario con validación
- `login(Request $request)`: Autenticar usuario y retornar token
- `logout(Request $request)`: Revocar token de acceso actual
- `me(Request $request)`: Obtener información del usuario autenticado
- `updateProfile(Request $request)`: Actualizar perfil del usuario
- `logoutAll(Request $request)`: Revocar todos los tokens del usuario
- `tokens(Request $request)`: Listar tokens del usuario
- `revokeToken(Request $request)`: Revocar token específico

### UsuarioController

Gestiona operaciones CRUD de usuarios y consultas específicas de usuarios.

**Métodos:**
- `index()`: Listar todos los usuarios
- `store(Request $request)`: Crear nuevo usuario
- `show($id)`: Obtener usuario por ID
- `update(Request $request, $id)`: Actualizar usuario
- `destroy($id)`: Eliminar usuario
- `getByRole($roleId)`: Obtener usuarios por rol
- `getByFormacion($formacionId)`: Obtener usuarios por formación
- `profile()`: Obtener perfil del usuario autenticado
- `getByIdentification(Request $request)`: Obtener usuario por número de identificación

### EquipoOElementoController

Gestiona equipos y elementos.

**Métodos:**
- `index()`: Listar todos los equipos
- `store(Request $request)`: Crear nuevo equipo
- `show($id)`: Obtener equipo por ID
- `update(Request $request, $id)`: Actualizar equipo
- `destroy($id)`: Eliminar equipo
- `getByUser()`: Obtener equipos asignados al usuario autenticado
- `getByHash(Request $request)`: Obtener equipo por hash QR

### FormacionController

Gestiona programas de formación.

**Métodos:**
- `index()`: Listar todos los programas de formación
- `store(Request $request)`: Crear nuevo programa de formación
- `show($id)`: Obtener programa de formación por ID
- `update(Request $request, $id)`: Actualizar programa de formación
- `destroy($id)`: Eliminar programa de formación
- `getByNivelFormacion($nivelFormacionId)`: Obtener programas por nivel de formación

### HistorialController

Gestiona el historial de entrada/salida de equipos.

**Métodos:**
- `index()`: Listar todas las entradas del historial
- `store(Request $request)`: Crear nueva entrada del historial
- `show($id)`: Obtener entrada del historial por ID
- `update(Request $request, $id)`: Actualizar entrada del historial
- `destroy($id)`: Eliminar entrada del historial
- `getByUsuario($usuarioId)`: Obtener historial por usuario
- `getByEquipo($equipoId)`: Obtener historial por equipo
- `registrarIngreso(Request $request)`: Registrar entrada de equipo
- `registrarSalida($id)`: Registrar salida de equipo
- `getByAuthUser()`: Obtener historial para el usuario autenticado
- `registerEntranceOrExit(Request $request)`: Registrar entrada o salida de equipo

### NivelFormacionController

Gestiona niveles de formación.

**Métodos:**
- `index()`: Listar todos los niveles de formación
- `store(Request $request)`: Crear nuevo nivel de formación
- `show($id)`: Obtener nivel de formación por ID
- `update(Request $request, $id)`: Actualizar nivel de formación
- `destroy($id)`: Eliminar nivel de formación

### ElementoAdicionalController

Gestiona elementos adicionales para equipos.

**Métodos:**
- `index()`: Listar todos los elementos adicionales
- `store(Request $request)`: Crear nuevo elemento adicional
- `show($id)`: Obtener elemento adicional por ID
- `update(Request $request, $id)`: Actualizar elemento adicional
- `destroy($id)`: Eliminar elemento adicional

### RoleController

Gestiona roles de usuario.

**Métodos:**
- `index()`: Listar todos los roles
- `store(Request $request)`: Crear nuevo rol
- `show($id)`: Obtener rol por ID
- `update(Request $request, $id)`: Actualizar rol
- `destroy($id)`: Eliminar rol

### EquipoElementoAdicionalController

Gestiona asignaciones de elementos adicionales a equipos.

**Métodos:**
- `index()`: Obtener todas las asignaciones de elementos adicionales a equipos
- `show($equipoId)`: Obtener elementos adicionales de un equipo específico
- `assign(Request $request)`: Asignar elementos adicionales a un equipo
- `detach(Request $request)`: Quitar elementos adicionales de un equipo

### PasswordResetController

Maneja la recuperación de contraseña.

**Métodos:**
- `sendResetCode(Request $request)`: Enviar código de reseteo por correo electrónico
- `verifyResetCode(Request $request)`: Verificar código de reseteo
- `resetPassword(Request $request)`: Restablecer contraseña del usuario

### ImageController

Maneja el acceso seguro a imágenes.

**Métodos:**
- `show($filename)`: Servir imagen con verificación de autorización

## Modelos y Relaciones

### User (Usuario)
- Pertenece a Role
- Pertenece a Formacion
- Tiene muchos EquipoOElemento (a través de UsuarioEquipo)
- Tiene muchos Historial

### Role
- Tiene muchos User

### Formacion
- Pertenece a NivelFormacion
- Tiene muchos User

### NivelFormacion
- Tiene muchas Formacion

### EquipoOElemento
- Tiene muchos ElementoAdicional
- Tiene muchos Historial
- Pertenece a muchos User (a través de UsuarioEquipo)

### ElementoAdicional
- Pertenece a EquipoOElemento

### Historial
- Pertenece a User
- Pertenece a EquipoOElemento

### PasswordReset
- Usado para el proceso de recuperación de contraseña

## Manejo de Errores

All endpoints return JSON responses with the following structure:

**Respuesta Exitosa:**
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {...}
}
```

**Respuesta de Error:**
```json
{
  "success": false,
  "message": "Error description",
  "error": "Detailed error message"
}
```

**Respuesta de Error de Validación:**
```json
{
  "success": false,
  "message": "Validation errors",
  "errors": {
    "field_name": ["Error message 1", "Error message 2"]
  }
}
```

## Códigos de Estado HTTP Comunes

- 200: Éxito
- 201: Creado
- 204: Sin Contenido
- 401: No Autorizado
- 403: Prohibido
- 404: No Encontrado
- 422: Error de Validación
- 500: Error Interno del Servidor

## Características de Seguridad

- **Autenticación**: Basada en tokens con Laravel Sanctum
- **Autorización**: Control de acceso basado en roles
- **Seguridad de Imágenes**: Acceso autorizado a imágenes subidas
- **Validación de Entrada**: Validación completa en todas las entradas
- **Hashing de Contraseñas**: Hashing Bcrypt para contraseñas
- **Gestión de Tokens**: Capacidad para revocar tokens
- **Limitación de Tasa**: Limitación de tasa integrada de Laravel

## Características en Tiempo Real

- **Transmisión**: Actualizaciones en tiempo real para cambios en el historial
- **Transmisión de Eventos**: Evento HistorialUpdated para actualizaciones en vivo

## Guía de Despliegue

### Prerrequisitos

- PHP 8.1 o superior
- Composer
- PostgreSQL
- Node.js y npm (para assets frontend si aplica)

### Despliegue con Docker (Recomendado)
Si bien Lumina se puede desplegar de manera manual, se recomienda el uso de Docker para facilitar el despliegue y garantizar la consistencia del entorno.

1. Construir la imagen Docker:

```bash
docker build -t lumina .
```

2. Ejecutar el contenedor:

```bash 
docker run -p 8000:80 lumina
```

Asegúrate de configurar las variables de entorno en un archivo .env montado en el contenedor:

```env
APP_KEY=(llave de aplicacion para cifrado y descifrado de informacion)
BROADCAST_CONNECTION=(Backend para transmision de eventos, por defecto se usa Pusher)
DB_CONNECTION=Base de datos a usar (por defecto se usa PostgreSQL)
DB_URL=Url para coneccion con la base de datos
PUSHER_APP_CLUSTER=Cluster de la aplicacion de Pusher
PUSHER_APP_ID=Id de la aplicacion de Pusher
PUSHER_APP_KEY=Llave de la aplicacion de Pusher
PUSHER_APP_SECRET=Secreto de la aplicacion de Pusher
QUEUE_CONNECTION=Manera en la que se maneja la cola de eventos, recomendado usar sync
```

### Despliegue Manual

1. Instalar dependencias de PHP:

```bash
composer install --no-dev --optimize-autoloader
```

2. Configurar el entorno:

Copia `.env.example` a `.env` y configura las variables necesarias (base de datos, APP_KEY, etc.).

```bash
cp .env.example .env
php artisan key:generate
```

3. Configurar la base de datos:

Asegúrate de que PostgreSQL esté corriendo y configura las credenciales en `.env`.

4. Ejecutar migraciones y seeders:

```bash
php artisan migrate:fresh --seed
```

5. Servir la aplicación:

Para desarrollo:
```bash
php artisan serve
```

Para producción, configura un servidor web como Nginx o Apache apuntando a `public/index.php`.

### Script de Despliegue

El proyecto incluye un script de despliegue en `scripts/00-laravel-deploy.sh` que automatiza la instalación de dependencias, cacheo y migraciones.

Esta documentación proporciona una visión general completa de la API Lumina. Para detalles de implementación, consulte los métodos de controlador y las relaciones de modelo.
