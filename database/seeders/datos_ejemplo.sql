-- Script SQL para Datos de Ejemplo
-- Proyecto: Lumina v2.0
-- Fecha: 2025-11-11

-- ============================================
-- 1. ROLES
-- ============================================
INSERT INTO roles (id, nombre_rol) VALUES
(1, 'usuario'),
(2, 'admin'),
(3, 'portero');

-- ============================================
-- 2. NIVELES DE FORMACIÓN
-- ============================================
INSERT INTO nivel_formacion (id, nivel_formacion) VALUES
(1, 'Técnico'),
(2, 'Tecnólogo'),
(3, 'Especialización Tecnológica'),
(4, 'Curso Complementario');

-- ============================================
-- 3. FORMACIONES
-- ============================================
INSERT INTO formacion (id, nivel_formacion_id, ficha, nombre_programa, fecha_inicio_programa, fecha_fin_programa) VALUES
(1, 2, '2024001', 'Análisis y Desarrollo de Software', '2024-01-15', '2025-12-31'),
(2, 2, '2024002', 'Gestión de Redes de Datos', '2024-02-01', '2025-11-30'),
(3, 1, '2024003', 'Sistemas de Información', '2024-03-01', '2024-12-31'),
(4, 3, '2024004', 'Seguridad Informática', '2024-04-01', '2025-10-31');

-- ============================================
-- 4. USUARIOS
-- ============================================
-- Password para todos: "password123" (hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi)

-- Admin
INSERT INTO usuarios (id, role_id, formacion_id, nombre, apellido, tipo_documento, documento, edad, numero_telefono, path_foto, email, password) VALUES
(1, 2, NULL, 'Carlos', 'Administrador', 'CC', '1234567890', 35, '3001234567', '/uploads/fotos/admin.jpg', 'admin@lumina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Portero
INSERT INTO usuarios (id, role_id, formacion_id, nombre, apellido, tipo_documento, documento, edad, numero_telefono, path_foto, email, password) VALUES
(2, 3, NULL, 'José', 'Portero García', 'CC', '2345678901', 40, '3102345678', '/uploads/fotos/portero.jpg', 'portero@lumina.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Usuarios/Aprendices
INSERT INTO usuarios (id, role_id, formacion_id, nombre, apellido, tipo_documento, documento, edad, numero_telefono, path_foto, email, password) VALUES
(3, 1, 1, 'Juan', 'Pérez López', 'CC', '3456789012', 22, '3203456789', '/uploads/fotos/juan.jpg', 'juan.perez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(4, 1, 1, 'María', 'García Rodríguez', 'CC', '4567890123', 23, '3304567890', '/uploads/fotos/maria.jpg', 'maria.garcia@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(5, 1, 2, 'Pedro', 'Martínez Sánchez', 'CC', '5678901234', 21, '3405678901', '/uploads/fotos/pedro.jpg', 'pedro.martinez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(6, 1, 2, 'Ana', 'López Hernández', 'CC', '6789012345', 24, '3506789012', '/uploads/fotos/ana.jpg', 'ana.lopez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(7, 1, 3, 'Luis', 'Ramírez Díaz', 'TI', '7890123456', 20, '3607890123', '/uploads/fotos/luis.jpg', 'luis.ramirez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(8, 1, 3, 'Laura', 'Torres Moreno', 'CC', '8901234567', 22, '3708901234', '/uploads/fotos/laura.jpg', 'laura.torres@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(9, 1, 4, 'Diego', 'Jiménez Castro', 'CC', '9012345678', 25, '3809012345', '/uploads/fotos/diego.jpg', 'diego.jimenez@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(10, 1, 4, 'Carmen', 'Ruiz Vargas', 'CC', '0123456789', 23, '3901234567', '/uploads/fotos/carmen.jpg', 'carmen.ruiz@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- ============================================
-- 5. EQUIPOS O ELEMENTOS
-- ============================================
INSERT INTO equipos_o_elementos (id, sn_equipo, marca, color, tipo_elemento, descripcion, qr_hash, path_foto_equipo_implemento) VALUES
-- Laptops
(1, 'LAP001', 'Dell', 'Negro', 'Laptop', 'Dell Inspiron 15 - Core i5 8GB RAM 256GB SSD', 'QR-LAP001-ABC123', '/uploads/equipos/laptop1.jpg'),
(2, 'LAP002', 'HP', 'Plata', 'Laptop', 'HP Pavilion 14 - Core i7 16GB RAM 512GB SSD', 'QR-LAP002-DEF456', '/uploads/equipos/laptop2.jpg'),
(3, 'LAP003', 'Lenovo', 'Negro', 'Laptop', 'Lenovo ThinkPad - Core i5 8GB RAM 256GB SSD', 'QR-LAP003-GHI789', '/uploads/equipos/laptop3.jpg'),
(4, 'LAP004', 'Asus', 'Azul', 'Laptop', 'Asus VivoBook - Core i3 8GB RAM 256GB SSD', 'QR-LAP004-JKL012', '/uploads/equipos/laptop4.jpg'),
(5, 'LAP005', 'Acer', 'Negro', 'Laptop', 'Acer Aspire - Core i5 8GB RAM 512GB SSD', 'QR-LAP005-MNO345', '/uploads/equipos/laptop5.jpg'),

-- Tablets
(6, 'TAB001', 'Samsung', 'Negro', 'Tablet', 'Samsung Galaxy Tab S7 - 128GB', 'QR-TAB001-PQR678', '/uploads/equipos/tablet1.jpg'),
(7, 'TAB002', 'Apple', 'Plata', 'Tablet', 'iPad Air - 256GB WiFi', 'QR-TAB002-STU901', '/uploads/equipos/tablet2.jpg'),
(8, 'TAB003', 'Lenovo', 'Gris', 'Tablet', 'Lenovo Tab M10 - 64GB', 'QR-TAB003-VWX234', '/uploads/equipos/tablet3.jpg'),

-- Proyectores
(9, 'PRO001', 'Epson', 'Blanco', 'Proyector', 'Epson PowerLite - 3500 lumens HDMI', 'QR-PRO001-YZA567', '/uploads/equipos/proyector1.jpg'),
(10, 'PRO002', 'BenQ', 'Negro', 'Proyector', 'BenQ MH535A - 3600 lumens Full HD', 'QR-PRO002-BCD890', '/uploads/equipos/proyector2.jpg'),

-- Cámaras
(11, 'CAM001', 'Canon', 'Negro', 'Cámara', 'Canon EOS Rebel T7 - Kit con lente 18-55mm', 'QR-CAM001-EFG123', '/uploads/equipos/camara1.jpg'),
(12, 'CAM002', 'Nikon', 'Negro', 'Cámara', 'Nikon D3500 - Kit con lente 18-55mm', 'QR-CAM002-HIJ456', '/uploads/equipos/camara2.jpg'),

-- Herramientas
(13, 'HER001', 'Varios', 'Multicolor', 'Kit Herramientas', 'Kit de destornilladores y herramientas básicas', 'QR-HER001-KLM789', '/uploads/equipos/herramientas1.jpg'),
(14, 'HER002', 'Klein Tools', 'Naranja', 'Multímetro', 'Multímetro digital profesional', 'QR-HER002-NOP012', '/uploads/equipos/multimetro1.jpg'),
(15, 'HER003', 'Various', 'Negro', 'Kit Networking', 'Kit para instalación de redes - Ponchadora, tester, etc', 'QR-HER003-QRS345', '/uploads/equipos/networking1.jpg');

-- ============================================
-- 6. ELEMENTOS ADICIONALES
-- ============================================
INSERT INTO elementos_adicionales (id, nombre_elemento, path_foto_elemento, equipos_o_elementos_id) VALUES
-- Para Laptops
(1, 'Cargador Dell 65W', '/uploads/elementos/cargador-dell.jpg', 1),
(2, 'Mouse USB Dell', '/uploads/elementos/mouse-dell.jpg', 1),
(3, 'Maletín protector', '/uploads/elementos/maletin-laptop.jpg', 1),

(4, 'Cargador HP 65W', '/uploads/elementos/cargador-hp.jpg', 2),
(5, 'Mouse inalámbrico HP', '/uploads/elementos/mouse-hp.jpg', 2),

(6, 'Cargador Lenovo 65W', '/uploads/elementos/cargador-lenovo.jpg', 3),
(7, 'Mouse USB Lenovo', '/uploads/elementos/mouse-lenovo.jpg', 3),

-- Para Tablets
(8, 'Cargador Samsung 25W', '/uploads/elementos/cargador-samsung.jpg', 6),
(9, 'S Pen', '/uploads/elementos/spen.jpg', 6),
(10, 'Funda protectora', '/uploads/elementos/funda-tablet.jpg', 6),

(11, 'Cargador Apple USB-C', '/uploads/elementos/cargador-apple.jpg', 7),
(12, 'Apple Pencil', '/uploads/elementos/apple-pencil.jpg', 7),

-- Para Proyectores
(13, 'Cable HDMI 3m', '/uploads/elementos/cable-hdmi.jpg', 9),
(14, 'Control remoto', '/uploads/elementos/control-proyector.jpg', 9),
(15, 'Cable de poder', '/uploads/elementos/cable-poder.jpg', 9),

-- Para Cámaras
(16, 'Batería extra Canon', '/uploads/elementos/bateria-canon.jpg', 11),
(17, 'Cargador Canon', '/uploads/elementos/cargador-canon.jpg', 11),
(18, 'Tarjeta SD 64GB', '/uploads/elementos/sd-card.jpg', 11),
(19, 'Trípode', '/uploads/elementos/tripode.jpg', 11);

-- ============================================
-- 7. USUARIO_EQUIPOS (Asignaciones)
-- ============================================
INSERT INTO usuario_equipos (id, usuario_id, equipos_o_elementos_id) VALUES
-- Juan tiene laptop y tablet
(1, 3, 1),
(2, 3, 6),

-- María tiene laptop
(3, 4, 2),

-- Pedro tiene laptop y kit de herramientas
(4, 5, 3),
(5, 5, 13),

-- Ana tiene laptop
(6, 6, 4),

-- Luis tiene laptop y cámara
(7, 7, 5),
(8, 7, 11),

-- Laura tiene tablet
(9, 8, 7),

-- Diego tiene proyector y herramientas
(10, 9, 9),
(11, 9, 14),

-- Carmen tiene cámara y kit de networking
(12, 10, 12),
(13, 10, 15);

-- ============================================
-- 8. HISTORIAL
-- ============================================
INSERT INTO historial (id, usuario_id, equipos_o_elementos_id, ingreso, salida) VALUES
-- Registros completos (con salida)
(1, 3, 1, '2024-11-01 08:00:00', '2024-11-01 17:00:00'),
(2, 3, 6, '2024-11-01 08:00:00', '2024-11-01 17:00:00'),
(3, 4, 2, '2024-11-01 08:30:00', '2024-11-01 16:30:00'),
(4, 5, 3, '2024-11-01 09:00:00', '2024-11-01 18:00:00'),
(5, 6, 4, '2024-11-01 07:30:00', '2024-11-01 17:30:00'),

-- Día 2
(6, 3, 1, '2024-11-02 08:00:00', '2024-11-02 17:00:00'),
(7, 4, 2, '2024-11-02 08:30:00', '2024-11-02 16:30:00'),
(8, 7, 5, '2024-11-02 09:00:00', '2024-11-02 18:00:00'),
(9, 7, 11, '2024-11-02 09:00:00', '2024-11-02 18:00:00'),

-- Día 3
(10, 3, 1, '2024-11-03 08:00:00', '2024-11-03 17:00:00'),
(11, 5, 3, '2024-11-03 08:30:00', '2024-11-03 17:30:00'),
(12, 9, 9, '2024-11-03 10:00:00', '2024-11-03 15:00:00'),

-- Registros actuales (sin salida - equipos actualmente en uso)
(13, 3, 1, '2024-11-11 08:00:00', NULL),
(14, 3, 6, '2024-11-11 08:00:00', NULL),
(15, 4, 2, '2024-11-11 08:30:00', NULL),
(16, 5, 3, '2024-11-11 09:00:00', NULL),
(17, 7, 5, '2024-11-11 09:00:00', NULL),
(18, 10, 12, '2024-11-11 10:00:00', NULL);

-- ============================================
-- RESETEAR AUTO_INCREMENT (Opcional)
-- ============================================
-- Descomentar si necesitas resetear los IDs
-- ALTER TABLE roles AUTO_INCREMENT = 4;
-- ALTER TABLE nivel_formacion AUTO_INCREMENT = 5;
-- ALTER TABLE formacion AUTO_INCREMENT = 5;
-- ALTER TABLE usuarios AUTO_INCREMENT = 11;
-- ALTER TABLE equipos_o_elementos AUTO_INCREMENT = 16;
-- ALTER TABLE elementos_adicionales AUTO_INCREMENT = 20;
-- ALTER TABLE usuario_equipos AUTO_INCREMENT = 14;
-- ALTER TABLE historial AUTO_INCREMENT = 19;

-- ============================================
-- VERIFICACIÓN DE DATOS
-- ============================================
-- Contar registros insertados
SELECT 'Roles' as Tabla, COUNT(*) as Total FROM roles
UNION ALL
SELECT 'Niveles de Formación', COUNT(*) FROM nivel_formacion
UNION ALL
SELECT 'Formaciones', COUNT(*) FROM formacion
UNION ALL
SELECT 'Usuarios', COUNT(*) FROM usuarios
UNION ALL
SELECT 'Equipos', COUNT(*) FROM equipos_o_elementos
UNION ALL
SELECT 'Elementos Adicionales', COUNT(*) FROM elementos_adicionales
UNION ALL
SELECT 'Usuario-Equipos', COUNT(*) FROM usuario_equipos
UNION ALL
SELECT 'Historial', COUNT(*) FROM historial;

-- Ver usuarios con sus roles
SELECT 
    u.id,
    u.nombre,
    u.apellido,
    r.nombre_rol as rol,
    f.ficha as ficha_formacion,
    f.nombre_programa
FROM usuarios u
LEFT JOIN roles r ON u.role_id = r.id
LEFT JOIN formacion f ON u.formacion_id = f.id
ORDER BY u.id;

-- Ver equipos asignados por usuario
SELECT 
    u.nombre,
    u.apellido,
    e.tipo_elemento,
    e.marca,
    e.sn_equipo
FROM usuarios u
INNER JOIN usuario_equipos ue ON u.id = ue.usuario_id
INNER JOIN equipos_o_elementos e ON ue.equipos_o_elementos_id = e.id
ORDER BY u.nombre, u.apellido;

-- Ver historial activo (equipos actualmente en uso)
SELECT 
    u.nombre,
    u.apellido,
    e.tipo_elemento,
    e.marca,
    e.sn_equipo,
    h.ingreso
FROM historial h
INNER JOIN usuarios u ON h.usuario_id = u.id
INNER JOIN equipos_o_elementos e ON h.equipos_o_elementos_id = e.id
WHERE h.salida IS NULL
ORDER BY h.ingreso DESC;

-- ============================================
-- NOTAS
-- ============================================
-- 1. Todos los usuarios tienen la contraseña: "password123"
-- 2. Los IDs están hardcodeados para mantener consistencia
-- 3. Los paths de las fotos son ejemplos, ajustar según tu estructura
-- 4. Los QR hashes son ejemplos, generar reales en producción
-- 5. Este script incluye datos de ejemplo completos para testing
