-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 04:52:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `malvishop_v2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(110) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `slug`, `parent_id`) VALUES
(1, 'Routers', 'routers', NULL),
(2, 'Switches', 'switches', NULL),
(3, 'Cables de red', 'cables-de-red', NULL),
(4, 'Herramientas', 'herramientas', NULL),
(5, 'Conectores', 'conectores', NULL),
(6, 'Patch Panels', 'patch-panels', NULL),
(7, 'Accesorios', 'accesorios', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) UNSIGNED NOT NULL,
  `precio_unitario_snapshot` decimal(12,2) NOT NULL,
  `nombre_producto_snapshot` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pago`
--

CREATE TABLE `estados_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados_pago`
--

INSERT INTO `estados_pago` (`id`, `nombre`) VALUES
(2, 'Aprobado'),
(1, 'Pendiente'),
(3, 'Rechazado'),
(4, 'Reembolsado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pedido`
--

CREATE TABLE `estados_pedido` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estados_pedido`
--

INSERT INTO `estados_pedido` (`id`, `nombre`) VALUES
(5, 'Cancelado'),
(4, 'Completado'),
(3, 'Enviado'),
(1, 'Pendiente de Pago'),
(2, 'Procesando');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_deseados`
--

CREATE TABLE `lista_deseados` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `fecha_agregado` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL DEFAULT 1,
  `estado_pago_id` int(11) NOT NULL DEFAULT 1,
  `total_pedido` decimal(12,2) NOT NULL,
  `direccion_envio_texto` text NOT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `id_transaccion_pago` varchar(255) DEFAULT NULL,
  `notas_cliente` text DEFAULT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_gestor`
--

CREATE TABLE `perfil_gestor` (
  `usuario_id` int(11) NOT NULL,
  `area_gestor` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(110) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `marca` varchar(100) NOT NULL,
  `codigo` varchar(50) NOT NULL COMMENT 'SKU del producto',
  `precio` decimal(12,2) NOT NULL,
  `stock` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `categoria_id` int(11) DEFAULT NULL,
  `imagen_principal` varchar(255) DEFAULT NULL,
  `especificaciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`especificaciones`)),
  `peso_kg` decimal(10,2) DEFAULT NULL,
  `largo_cm` decimal(10,2) DEFAULT NULL,
  `ancho_cm` decimal(10,2) DEFAULT NULL,
  `alto_cm` decimal(10,2) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `destacado` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `slug`, `descripcion`, `marca`, `codigo`, `precio`, `stock`, `categoria_id`, `imagen_principal`, `especificaciones`, `peso_kg`, `largo_cm`, `ancho_cm`, `alto_cm`, `activo`, `destacado`, `fecha_creacion`) VALUES
(14, 'Router Wi-Fi TP-Link Archer C6 AC1200', 'router-wifi-tp-link-archer-c6-ac1200', 'Router inalámbrico dual band ideal para hogares y oficinas pequeñas.', 'TP-Link', 'TL-ARCHER-C6', 24999.99, 15, 1, 'img/productos/archer-c6.jpg', '{\"frecuencia\": \"2.4GHz/5GHz\", \"puertos_lan\": 4, \"puerto_wan\": 1, \"estandares\": [\"IEEE 802.11ac\", \"802.11n\"]}', 0.80, 25.00, 18.00, 4.50, 1, 1, '2025-07-09 02:02:22'),
(15, 'Router Mikrotik hAP ac²', 'router-mikrotik-hap-ac2', 'Router profesional para redes domésticas o PyMEs.', 'Mikrotik', 'RB-HAP-AC2', 41999.99, 10, 1, 'img/productos/hap-ac2.jpg', '{\"cpu\": \"4-core\", \"ram\": \"128MB\", \"puertos_ethernet\": 5, \"frecuencia\": \"2.4/5GHz\"}', 0.60, 12.00, 10.00, 3.50, 1, 0, '2025-07-09 02:02:22'),
(16, 'Switch Gigabit TP-Link 8 Puertos TL-SG108', 'switch-gigabit-tp-link-8p', 'Switch de escritorio metálico sin gestión.', 'TP-Link', 'TL-SG108', 16999.99, 25, 2, 'img/productos/switch-8p.jpg', '{\"puertos\": 8, \"tipo\": \"No administrable\", \"velocidad\": \"Gigabit\"}', 0.40, 16.00, 10.00, 3.00, 1, 1, '2025-07-09 02:02:22'),
(17, 'Switch Cisco SG250-08HP PoE 8p', 'switch-cisco-sg250-08hp-poe', 'Switch PoE administrable con capacidades de red avanzadas.', 'Cisco', 'SG250-08HP', 97999.00, 5, 2, 'img/productos/switch-cisco.jpg', '{\"puertos\": 8, \"poe\": true, \"gestion\": \"L2/L3\", \"velocidad\": \"1Gbps\"}', 0.90, 20.00, 15.00, 4.00, 1, 0, '2025-07-09 02:02:22'),
(18, 'Cable de red UTP Cat6 x10m', 'cable-utp-cat6-10m', 'Cable UTP categoría 6 de 10 metros con conectores RJ45.', 'Nexxt', 'UTP-CAT6-10M', 3999.00, 100, 3, 'img/productos/cable-cat6.jpg', '{\"longitud\": \"10m\", \"categoria\": \"Cat6\", \"blindado\": false}', 0.30, 1000.00, 1.00, 1.00, 1, 0, '2025-07-09 02:02:22'),
(19, 'Cable de red FTP Cat6 x25m', 'cable-ftp-cat6-25m', 'Cable de red FTP categoría 6 blindado, 25 metros.', 'Intelbras', 'FTP-CAT6-25M', 8499.00, 40, 3, 'img/productos/cable-ftp.jpg', '{\"longitud\": \"25m\", \"categoria\": \"Cat6\", \"blindado\": true}', 0.80, 2500.00, 1.00, 1.00, 1, 1, '2025-07-09 02:02:22'),
(20, 'Crimpadora RJ45 universal', 'crimpadora-rj45-universal', 'Herramienta para crimpar conectores RJ45, RJ11 y RJ12.', 'Truper', 'CRIMP-RJ45', 7999.99, 30, 4, 'img/productos/crimpadora.jpg', '{\"compatible\": [\"RJ45\", \"RJ11\", \"RJ12\"], \"material\": \"metal reforzado\"}', 0.50, 22.00, 7.00, 3.00, 1, 0, '2025-07-09 02:02:22'),
(21, 'Tester de red RJ45/RJ11 portátil', 'tester-red-rj45-rj11', 'Dispositivo para probar continuidad en cables de red y teléfono.', 'GTC', 'TESTER-RJ', 3999.00, 50, 4, 'img/productos/tester-red.jpg', '{\"formatos\": [\"RJ45\", \"RJ11\"], \"alimentacion\": \"9V\", \"modo\": \"manual y automático\"}', 0.30, 15.00, 8.00, 3.00, 1, 0, '2025-07-09 02:02:22'),
(22, 'Conector RJ45 Cat6 x100u', 'conector-rj45-cat6-x100', 'Bolsa de 100 conectores RJ45 categoría 6.', 'Genérico', 'RJ45-CAT6-X100', 5999.00, 60, 5, 'img/productos/rj45-100.jpg', '{\"cantidad\": 100, \"categoria\": \"Cat6\", \"tipo\": \"8P8C\"}', 0.40, 10.00, 5.00, 3.00, 1, 1, '2025-07-09 02:02:22'),
(23, 'Pasacable red redondo 50mm', 'pasacable-redondo-50mm', 'Pasacable redondo de plástico para escritorios.', 'Genérico', 'PASACABLE-50MM', 1299.00, 80, 5, 'img/productos/pasacable.jpg', '{\"diametro\": \"50mm\", \"material\": \"plástico ABS\", \"color\": \"negro\"}', 0.20, 5.00, 5.00, 2.00, 1, 0, '2025-07-09 02:02:22'),
(24, 'Patch Panel 24 puertos Cat6 UTP', 'patch-panel-24p-cat6', 'Panel de parcheo de 24 puertos para Cat6.', 'Nexxt', 'PATCH24-CAT6', 18999.00, 20, 6, 'img/productos/patchpanel-24.jpg', '{\"puertos\": 24, \"categoria\": \"Cat6\", \"formato\": \"1U rack\"}', 1.10, 48.00, 5.00, 5.00, 1, 1, '2025-07-09 02:02:22'),
(25, 'Organizador de cables 1U para rack', 'organizador-cables-1u', 'Accesorio metálico para organización de cables en rack.', 'Forza', 'ORGANIZADOR-1U', 3999.00, 35, 7, 'img/productos/organizador.jpg', '{\"altura\": \"1U\", \"material\": \"acero\", \"uso\": \"rack 19 pulgadas\"}', 0.70, 48.00, 6.00, 4.00, 1, 0, '2025-07-09 02:02:22'),
(26, 'Antena Wi-Fi 8dBi SMA', 'antena-wifi-8dbi-sma', 'Antena externa para routers y placas de red.', 'Ubiquiti', 'ANT-WIFI-8DBI', 2999.00, 45, 7, 'img/productos/antena.jpg', '{\"ganancia\": \"8dBi\", \"conector\": \"SMA\", \"frecuencia\": \"2.4GHz\"}', 0.10, 20.00, 2.00, 2.00, 1, 1, '2025-07-09 02:02:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`) VALUES
(3, 'administrador'),
(1, 'cliente'),
(2, 'gestor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL DEFAULT 1,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `cuit_cuil` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(10) DEFAULT NULL,
  `descripcion_fachada` text DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `rol_id`, `nombre`, `apellido`, `dni`, `cuit_cuil`, `email`, `password`, `telefono`, `foto_perfil`, `direccion`, `codigo_postal`, `descripcion_fachada`, `activo`, `fecha_creacion`) VALUES
(1, 1, 'Juan', 'Pérez', '30123456', '20-30123456-7', 'juan.perez1@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456789', NULL, 'Av. Siempre Viva 123', '1000', 'Puerta roja con rejas', 1, '2025-07-09 01:59:29'),
(2, 1, 'Ana', 'Gómez', '32123456', '27-32123456-6', 'ana.gomez@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456790', NULL, 'Calle Falsa 456', '1001', 'Casa blanca', 1, '2025-07-09 01:59:29'),
(3, 1, 'Carlos', 'Rodríguez', '33123456', '20-33123456-9', 'carlos.r@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456791', NULL, 'Diagonal Norte 789', '1002', 'Edificio 3º B', 1, '2025-07-09 01:59:29'),
(4, 1, 'María', 'López', '34123456', '27-34123456-4', 'maria.lopez@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456792', NULL, 'Av. Belgrano 321', '1003', 'Frente a la plaza', 1, '2025-07-09 01:59:29'),
(5, 1, 'Luis', 'Martínez', '35123456', '20-35123456-1', 'luis.m@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456793', NULL, 'San Martín 654', '1004', 'Puerta azul', 1, '2025-07-09 01:59:29'),
(6, 1, 'Sofía', 'Fernández', '36123456', '27-36123456-8', 'sofia.fernandez@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456794', NULL, 'Av. Rivadavia 987', '1005', 'Pared ladrillo visto', 1, '2025-07-09 01:59:29'),
(7, 1, 'Jorge', 'Ramírez', '37123456', '20-37123456-5', 'jorge.ramirez@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456795', NULL, 'Mitre 147', '1006', 'Casa con portón verde', 1, '2025-07-09 01:59:29'),
(8, 1, 'Camila', 'Díaz', '38123456', '27-38123456-2', 'camila.diaz@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456796', NULL, 'Urquiza 258', '1007', 'Depto PB A', 1, '2025-07-09 01:59:29'),
(9, 1, 'Pedro', 'Sánchez', '39123456', '20-39123456-9', 'pedro.sanchez@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456797', NULL, 'Lavalle 369', '1008', 'Frente amarillo', 1, '2025-07-09 01:59:29'),
(10, 1, 'Lucía', 'Torres', '40123456', '27-40123456-6', 'lucia.torres@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456798', NULL, 'Sarmiento 741', '1009', 'Entrada angosta', 1, '2025-07-09 01:59:29'),
(11, 1, 'Diego', 'Castro', '41123456', '20-41123456-3', 'diego.castro@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456799', NULL, 'Corrientes 852', '1010', 'Balcón con plantas', 1, '2025-07-09 01:59:29'),
(12, 1, 'Valentina', 'Flores', '42123456', '27-42123456-0', 'valentina.flores@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456700', NULL, 'Moreno 963', '1011', 'Rejas blancas', 1, '2025-07-09 01:59:29'),
(13, 1, 'Nicolás', 'Gutiérrez', '43123456', '20-43123456-7', 'nicolas.g@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456701', NULL, 'Entre Ríos 159', '1012', 'Garaje al frente', 1, '2025-07-09 01:59:29'),
(14, 1, 'Florencia', 'Paz', '44123456', '27-44123456-4', 'florencia.paz@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456702', NULL, 'Callao 753', '1013', 'Casa de dos pisos', 1, '2025-07-09 01:59:29'),
(15, 1, 'Martín', 'Silva', '45123456', '20-45123456-1', 'martin.silva@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456703', NULL, 'Alberdi 852', '1014', 'Techo de chapa roja', 1, '2025-07-09 01:59:29'),
(16, 1, 'Julieta', 'Mendoza', '46123456', '27-46123456-8', 'julieta.mendoza@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456704', NULL, 'Roca 951', '1015', 'Cerca de un kiosco', 1, '2025-07-09 01:59:29'),
(17, 1, 'Matías', 'Acosta', '47123456', '20-47123456-5', 'matias.acosta@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456705', NULL, 'Pellegrini 123', '1016', 'Edificio con ascensor', 1, '2025-07-09 01:59:29'),
(18, 1, 'Agustina', 'Ríos', '48123456', '27-48123456-2', 'agustina.rios@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456706', NULL, 'Yrigoyen 234', '1017', 'Con portero eléctrico', 1, '2025-07-09 01:59:29'),
(19, 1, 'Facundo', 'Ortega', '49123456', '20-49123456-9', 'facundo.ortega@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456707', NULL, 'Saavedra 345', '1018', 'Garage pintado', 1, '2025-07-09 01:59:29'),
(20, 1, 'Carla', 'Vega', '50123456', '27-50123456-6', 'carla.vega@mail.com', '$2y$10$abcdef123456abcdef1234uP2o6bkqx8c2uGupvBFeZI1HKV1i3GW', '1123456708', NULL, 'Balcarce 456', '1019', 'Edificio vidriado', 1, '2025-07-09 01:59:29');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `estados_pago`
--
ALTER TABLE `estados_pago`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `lista_deseados`
--
ALTER TABLE `lista_deseados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `deseo_unico` (`usuario_id`,`producto_id`),
  ADD KEY `idx_usuario_id` (`usuario_id`),
  ADD KEY `idx_producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `estado_id` (`estado_id`),
  ADD KEY `estado_pago_id` (`estado_pago_id`);

--
-- Indices de la tabla `perfil_gestor`
--
ALTER TABLE `perfil_gestor`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `idx_dni_unique` (`dni`),
  ADD UNIQUE KEY `idx_cuit_cuil_unique` (`cuit_cuil`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados_pago`
--
ALTER TABLE `estados_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_pedido`
--
ALTER TABLE `estados_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `lista_deseados`
--
ALTER TABLE `lista_deseados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `lista_deseados`
--
ALTER TABLE `lista_deseados`
  ADD CONSTRAINT `fk_deseados_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_deseados_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`estado_id`) REFERENCES `estados_pedido` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`estado_pago_id`) REFERENCES `estados_pago` (`id`);

--
-- Filtros para la tabla `perfil_gestor`
--
ALTER TABLE `perfil_gestor`
  ADD CONSTRAINT `perfil_gestor_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
