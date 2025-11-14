-- Script SQL para llenar la base de datos Lumina
-- Fecha: 2025-11-12
-- 10 registros por tabla con datos completos

-- ============================================
-- LIMPIEZA DE TABLAS (en orden de dependencias)
-- ============================================
SET FOREIGN_KEY_CHECKS = 0;

TRUNCATE TABLE historial;
TRUNCATE TABLE usuario_equipos;
TRUNCATE TABLE elementos_adicionales;
TRUNCATE TABLE equipos_o_elementos;
TRUNCATE TABLE usuarios;
TRUNCATE TABLE formacion;
TRUNCATE TABLE nivel_formacion;
TRUNCATE TABLE roles;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- ROLES (3 roles básicos)
-- ============================================
INSERT INTO roles (id, nombre_rol) VALUES
(1, 'admin'),
(2, 'portero'),
(3, 'usuario');

-- ============================================
-- NIVEL FORMACIÓN (10 registros)
-- ============================================
INSERT INTO nivel_formacion (id, nivel_formacion) VALUES
(1, 'Técnico'),
(2, 'Tecnólogo'),
(3, 'Profesional'),
(4, 'Especialización'),
(5, 'Maestría'),
(6, 'Doctorado'),
(7, 'Bachiller'),
(8, 'Técnico Laboral'),
(9, 'Diplomado'),
(10, 'Certificación');

-- ============================================
-- FORMACIÓN (10 registros)
-- ============================================
INSERT INTO formacion (id, nivel_formacion_id, ficha, nombre_programa, fecha_inicio_programa, fecha_fin_programa) VALUES
(1, 1, '2758901', 'Técnico en Sistemas', '2024-01-15', '2025-06-30'),
(2, 2, '2758902', 'Tecnólogo en Análisis y Desarrollo de Software', '2024-02-01', '2026-12-15'),
(3, 3, '2758903', 'Ingeniería de Sistemas', '2023-08-01', '2028-06-30'),
(4, 2, '2758904', 'Tecnólogo en Gestión de Redes', '2024-03-10', '2026-11-20'),
(5, 1, '2758905', 'Técnico en Programación', '2024-01-20', '2025-07-15'),
(6, 2, '2758906', 'Tecnólogo en Desarrollo Web', '2024-02-15', '2026-12-01'),
(7, 3, '2758907', 'Ingeniería de Software', '2023-09-01', '2028-07-30'),
(8, 1, '2758908', 'Técnico en Bases de Datos', '2024-04-01', '2025-10-15'),
(9, 2, '2758909', 'Tecnólogo en Ciberseguridad', '2024-01-25', '2026-11-30'),
(10, 1, '2758910', 'Técnico en Soporte IT', '2024-03-01', '2025-09-20');

-- ============================================
-- USUARIOS (10 registros: 2 admin, 2 porteros, 6 usuarios)
-- ============================================
-- Password: todas las contraseñas son 'password' hasheado con bcrypt
INSERT INTO usuarios (id, role_id, formacion_id, nombre, apellido, tipo_documento, documento, edad, numero_telefono, path_foto, email, password) VALUES
-- Administradores
(1, 1, NULL, 'Carlos', 'Martínez', 'CC', '1012345678', 35, '3001234567', '/storage/fotos/admin1.jpg', 'carlos.martinez@lumina.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(2, 1, NULL, 'María', 'Rodríguez', 'CC', '1012345679', 32, '3001234568', '/storage/fotos/admin2.jpg', 'maria.rodriguez@lumina.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),

-- Porteros
(3, 2, NULL, 'Jorge', 'López', 'CC', '1012345680', 45, '3001234569', '/storage/fotos/portero1.jpg', 'jorge.lopez@lumina.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(4, 2, NULL, 'Ana', 'García', 'CC', '1012345681', 38, '3001234570', '/storage/fotos/portero2.jpg', 'ana.garcia@lumina.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),

-- Usuarios (Aprendices)
(5, 3, 1, 'Juan', 'Pérez', 'CC', '1023456789', 22, '3101234567', '/storage/fotos/usuario1.jpg', 'juan.perez@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(6, 3, 2, 'Sofía', 'Hernández', 'CC', '1023456790', 21, '3101234568', '/storage/fotos/usuario2.jpg', 'sofia.hernandez@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(7, 3, 3, 'Diego', 'Ramírez', 'CC', '1023456791', 23, '3101234569', '/storage/fotos/usuario3.jpg', 'diego.ramirez@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(8, 3, 4, 'Valentina', 'Torres', 'CC', '1023456792', 20, '3101234570', '/storage/fotos/usuario4.jpg', 'valentina.torres@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(9, 3, 5, 'Andrés', 'Gómez', 'CC', '1023456793', 24, '3101234571', '/storage/fotos/usuario5.jpg', 'andres.gomez@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube'),
(10, 3, 6, 'Camila', 'Morales', 'CC', '1023456794', 22, '3101234572', '/storage/fotos/usuario6.jpg', 'camila.morales@aprendiz.edu.co', '$2y$12$q5a/apKLOpuSkdpL9LYeIeKpeY1FK0JVEpgcEJaZdx18ql8E3vube');

-- ============================================
-- EQUIPOS O ELEMENTOS (10 registros)
-- ============================================
INSERT INTO equipos_o_elementos (id, sn_equipo, marca, color, tipo_elemento, descripcion, qr_hash, path_foto_equipo_implemento) VALUES
(1, 'LAP001HP2024', 'HP', 'Negro', 'Laptop', 'HP Pavilion 15, Intel i5, 8GB RAM, 256GB SSD', 'QR001HP2024LAP', '/storage/equipos/laptop_hp_1.jpg'),
(2, 'LAP002DL2024', 'Dell', 'Plata', 'Laptop', 'Dell Inspiron 14, Intel i7, 16GB RAM, 512GB SSD', 'QR002DL2024LAP', '/storage/equipos/laptop_dell_2.jpg'),
(3, 'LAP003LN2024', 'Lenovo', 'Negro', 'Laptop', 'Lenovo ThinkPad, Intel i5, 8GB RAM, 256GB SSD', 'QR003LN2024LAP', '/storage/equipos/laptop_lenovo_3.jpg'),
(4, 'LAP004AC2024', 'Acer', 'Azul', 'Laptop', 'Acer Aspire 5, AMD Ryzen 5, 12GB RAM, 512GB SSD', 'QR004AC2024LAP', '/storage/equipos/laptop_acer_4.jpg'),
(5, 'LAP005AS2024', 'Asus', 'Gris', 'Laptop', 'Asus VivoBook, Intel i3, 8GB RAM, 256GB SSD', 'QR005AS2024LAP', '/storage/equipos/laptop_asus_5.jpg'),
(6, 'TAB001SM2024', 'Samsung', 'Negro', 'Tablet', 'Samsung Galaxy Tab S7, 128GB, WiFi', 'QR006SM2024TAB', '/storage/equipos/tablet_samsung_6.jpg'),
(7, 'TAB002AP2024', 'Apple', 'Plata', 'Tablet', 'iPad Air 10.9, 256GB, WiFi', 'QR007AP2024TAB', '/storage/equipos/tablet_apple_7.jpg'),
(8, 'PRO001LG2024', 'LG', 'Negro', 'Proyector', 'Proyector LG Full HD, 3000 lúmenes', 'QR008LG2024PRO', '/storage/equipos/proyector_lg_8.jpg'),
(9, 'ROU001TP2024', 'TP-Link', 'Blanco', 'Router', 'Router TP-Link AC1750, Dual Band', 'QR009TP2024ROU', '/storage/equipos/router_tplink_9.jpg'),
(10, 'MON001SM2024', 'Samsung', 'Negro', 'Monitor', 'Monitor Samsung 24 pulgadas Full HD', 'QR010SM2024MON', '/storage/equipos/monitor_samsung_10.jpg');

-- ============================================
-- ELEMENTOS ADICIONALES (10 registros)
-- ============================================
-- Accesorios para los equipos
INSERT INTO elementos_adicionales (id, nombre_elemento, path_foto_elemento, equipos_o_elementos_id) VALUES
(1, 'Cargador HP Original 65W', '/storage/elementos/cargador_hp_1.jpg', 1),
(2, 'Mouse Inalámbrico Logitech', '/storage/elementos/mouse_logitech_1.jpg', 1),
(3, 'Cargador Dell Original 90W', '/storage/elementos/cargador_dell_2.jpg', 2),
(4, 'Base Refrigerante para Laptop', '/storage/elementos/base_refrigerante_2.jpg', 2),
(5, 'Cargador Lenovo Original 65W', '/storage/elementos/cargador_lenovo_3.jpg', 3),
(6, 'Maletín para Laptop 15.6"', '/storage/elementos/maletin_3.jpg', 3),
(7, 'Cargador Acer Original 65W', '/storage/elementos/cargador_acer_4.jpg', 4),
(8, 'Teclado USB Externo', '/storage/elementos/teclado_usb_4.jpg', 4),
(9, 'Cargador Samsung Tablet', '/storage/elementos/cargador_samsung_6.jpg', 6),
(10, 'Cable HDMI 2.0 - 2 metros', '/storage/elementos/cable_hdmi_8.jpg', 8);

-- ============================================
-- USUARIO_EQUIPOS (Asignación de equipos a usuarios)
-- ============================================
-- Los usuarios (aprendices) tienen equipos asignados
-- Admin y porteros no tienen equipos asignados
INSERT INTO usuario_equipos (id, usuario_id, equipos_o_elementos_id) VALUES
-- Usuario 5 (Juan Pérez) - Laptop HP + Tablet Samsung
(1, 5, 1),
(2, 5, 6),

-- Usuario 6 (Sofía Hernández) - Laptop Dell
(3, 6, 2),

-- Usuario 7 (Diego Ramírez) - Laptop Lenovo + Monitor
(4, 7, 3),
(5, 7, 10),

-- Usuario 8 (Valentina Torres) - Laptop Acer
(6, 8, 4),

-- Usuario 9 (Andrés Gómez) - Laptop Asus + Proyector
(7, 9, 5),
(8, 9, 8),

-- Usuario 10 (Camila Morales) - Tablet Apple + Router
(9, 10, 7),
(10, 10, 9);

-- ============================================
-- HISTORIAL (10 registros de entrada/salida)
-- ============================================
INSERT INTO historial (id, usuario_id, equipos_o_elementos_id, ingreso, salida) VALUES
-- Registros completos (con entrada y salida)
(1, 5, 1, '2024-11-11 07:30:00', '2024-11-11 17:45:00'),
(2, 6, 2, '2024-11-11 08:00:00', '2024-11-11 16:30:00'),
(3, 7, 3, '2024-11-11 07:45:00', '2024-11-11 18:00:00'),
(4, 8, 4, '2024-11-11 08:15:00', '2024-11-11 17:00:00'),
(5, 9, 5, '2024-11-11 07:50:00', '2024-11-11 17:30:00'),

-- Registros del día actual (solo entrada, sin salida - usuarios actualmente en el centro)
(6, 5, 1, '2024-11-12 07:35:00', NULL),
(7, 6, 2, '2024-11-12 08:05:00', NULL),
(8, 7, 3, '2024-11-12 07:40:00', NULL),
(9, 10, 7, '2024-11-12 08:20:00', NULL),
(10, 9, 8, '2024-11-12 07:55:00', NULL);

-- ============================================
-- VERIFICACIÓN DE DATOS
-- ============================================
-- Descomentar las siguientes líneas para verificar los datos insertados

-- SELECT 'ROLES' as tabla, COUNT(*) as total FROM roles
-- UNION ALL
-- SELECT 'NIVEL_FORMACION', COUNT(*) FROM nivel_formacion
-- UNION ALL
-- SELECT 'FORMACION', COUNT(*) FROM formacion
-- UNION ALL
-- SELECT 'USUARIOS', COUNT(*) FROM usuarios
-- UNION ALL
-- SELECT 'EQUIPOS_O_ELEMENTOS', COUNT(*) FROM equipos_o_elementos
-- UNION ALL
-- SELECT 'ELEMENTOS_ADICIONALES', COUNT(*) FROM elementos_adicionales
-- UNION ALL
-- SELECT 'USUARIO_EQUIPOS', COUNT(*) FROM usuario_equipos
-- UNION ALL
-- SELECT 'HISTORIAL', COUNT(*) FROM historial;

-- ============================================
-- CONSULTAS DE VERIFICACIÓN ADICIONALES
-- ============================================

-- Ver usuarios por rol
-- SELECT r.nombre_rol, COUNT(u.id) as cantidad
-- FROM roles r
-- LEFT JOIN usuarios u ON r.id = u.role_id
-- GROUP BY r.nombre_rol;

-- Ver equipos asignados por usuario
-- SELECT u.nombre, u.apellido, u.email, 
--        GROUP_CONCAT(e.tipo_elemento, ' - ', e.marca SEPARATOR ', ') as equipos
-- FROM usuarios u
-- LEFT JOIN usuario_equipos ue ON u.id = ue.usuario_id
-- LEFT JOIN equipos_o_elementos e ON ue.equipos_o_elementos_id = e.id
-- WHERE u.role_id = 3
-- GROUP BY u.id, u.nombre, u.apellido, u.email;

-- Ver elementos adicionales por equipo
-- SELECT e.tipo_elemento, e.marca, e.sn_equipo,
--        GROUP_CONCAT(ea.nombre_elemento SEPARATOR ', ') as accesorios
-- FROM equipos_o_elementos e
-- LEFT JOIN elementos_adicionales ea ON e.id = ea.equipos_o_elementos_id
-- GROUP BY e.id, e.tipo_elemento, e.marca, e.sn_equipo;

-- ============================================
-- FIN DEL SCRIPT
-- ============================================
