-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-09-2026 a las 16:46:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shena`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `pedidos_id` int(11) NOT NULL,
  `productos_codigo` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `costototal` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `ci` int(11) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT 'Abierto',
  `vendedor` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `metodoPago` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `costo` decimal(10,2) DEFAULT 0.00,
  `stock` int(11) DEFAULT 0,
  `imagen` varchar(200) DEFAULT NULL,
  `estado` enum('Activo','Inactivo') DEFAULT 'Activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `precio`, `costo`, `stock`, `imagen`, `estado`) VALUES
(1, 'Serum de Coco', 'Serum hidratante de coco', 45.00, 30.00, 30, 'zpr2.jpeg', 'Activo'),
(2, 'Despigmentante de Achachairu', 'Despigmentante natural de Achachairu', 55.00, 40.00, 30, 'zpr6.jpeg', 'Activo'),
(3, 'Serum de Tamarindo', 'Serum natural de tamarindo', 48.00, 35.00, 30, 'zpr19.jpeg', 'Activo'),
(4, 'Aceite Antiestres de Cacao', 'Aceite relajante de cacao', 40.00, 28.00, 30, 'zpr16.jpeg', 'Activo'),
(5, 'Serum de Chirimoya', 'Serum de chirimoya para la piel', 47.00, 34.00, 30, 'zpr18.jpeg', 'Activo'),
(6, 'Flores de Kantuta', 'Producto natural de flores de kantuta', 35.00, 22.00, 30, 'zpr21.jpeg', 'Activo'),
(7, 'Aceite de Copaiba', 'Aceite natural de copaiba', 50.00, 36.00, 30, 'zpr22.jpeg', 'Activo'),
(8, 'Gel de Quinua', 'Gel natural de quinua', 33.00, 20.00, 30, 'zpr11.jpeg', 'Activo'),
(9, 'Gel de Pepino', 'Gel refrescante de pepino', 30.00, 18.00, 30, 'zpr5.jpeg', 'Activo'),
(10, 'Gel de Sabila', 'Gel de sábila hidratante', 28.00, 16.00, 30, 'zpr7.jpeg', 'Activo'),
(11, 'Aceite de Coco', 'Aceite natural de coco', 38.00, 25.00, 30, 'zpr14.jpeg', 'Activo'),
(12, 'Bruma de Eucalipto', 'Bruma refrescante de eucalipto', 32.00, 20.00, 30, 'zpr24.jpeg', 'Activo'),
(13, 'Suavizante de Papaya', 'Suavizante natural de papaya', 30.00, 18.00, 30, 'zpr3.jpeg', 'Activo'),
(14, 'Balsamo de Matico', 'Bálsamo de matico', 42.00, 28.00, 30, 'zpr4.jpeg', 'Activo'),
(15, 'Crema de Maracuya y Sabila', 'Crema natural de maracuyá y sábila', 37.00, 24.00, 30, 'zpr8.jpeg', 'Activo'),
(16, 'Exfoliante de Cafe', 'Exfoliante natural de café', 34.00, 22.00, 30, 'zpr23.jpeg', 'Activo'),
(17, 'Crema Matificante', 'Crema matificante facial', 39.00, 26.00, 30, 'zpr25.jpeg', 'Activo'),
(18, 'Jabon de Semilla de Tarwi', 'Jabón de tarwi', 18.00, 10.00, 30, 'zpr9.jpeg', 'Activo'),
(19, 'Jabon de Avena y Miel', 'Jabón de avena y miel', 20.00, 12.00, 30, 'zpr44.jpeg', 'Activo'),
(20, 'Jabon de Rosa Mosqueta', 'Jabón de rosa mosqueta', 22.00, 14.00, 30, 'zpr45.jpeg', 'Activo'),
(21, 'Jabon de Curcuma y Manzanilla', 'Jabón de cúrcuma y manzanilla', 20.00, 12.00, 30, 'zpr46.jpeg', 'Activo'),
(22, 'Jabon de Carbon Activado', 'Jabón de carbón activado', 22.00, 14.00, 30, 'zpr47.jpeg', 'Activo'),
(23, 'Desmaquillante de Chia', 'Desmaquillante natural de chia', 28.00, 18.00, 30, 'zpr1.jpeg', 'Activo'),
(24, 'Desmaquillante de Manzanilla y Avena', 'Desmaquillante natural de manzanilla y avena', 30.00, 19.00, 30, 'zpr34.jpeg', 'Activo'),
(25, 'Desmaquillante de Uva Morada', 'Desmaquillante natural de uva morada', 32.00, 20.00, 30, 'zpr33.jpeg', 'Activo'),
(26, 'Desmaquillante de Pepino', 'Desmaquillante refrescante de pepino', 27.00, 17.00, 30, 'zpr31.jpeg', 'Activo'),
(27, 'Desmaquillante Leche de Coco', 'Desmaquillante nutritivo de leche de coco', 29.00, 18.00, 30, 'zpr32.jpeg', 'Activo'),
(28, 'Desmaquillante de Agua de Rosas', 'Desmaquillante de agua de rosas', 28.00, 18.00, 30, 'zpr30.jpeg', 'Activo'),
(29, 'Balsamo de Castaña', 'Bálsamo nutritivo de castaña', 20.00, 12.00, 30, 'zpr12.jpeg', 'Activo'),
(30, 'Balsamo de Frambuesa', 'Bálsamo de frambuesa', 20.00, 12.00, 30, 'zpr27.jpeg', 'Activo'),
(31, 'Balsamo de Maracuya', 'Bálsamo de maracuyá', 20.00, 12.00, 30, 'zpr28.jpeg', 'Activo'),
(32, 'Balsamo de Vainilla y Coco', 'Bálsamo de vainilla y coco', 22.00, 13.00, 30, 'zpr29.jpeg', 'Activo'),
(33, 'Balsamo de Frutilla', 'Bálsamo de frutilla', 20.00, 12.00, 30, 'zpr26.jpeg', 'Activo'),
(34, 'Perfume Solido de Orquidea', 'Perfume sólido de orquídea', 35.00, 22.00, 30, 'zpr13.jpeg', 'Activo'),
(35, 'Perfume Solido de Bergamota', 'Perfume sólido de bergamota', 35.00, 22.00, 30, 'zpr35.jpeg', 'Activo'),
(36, 'Perfume Solido de Frutilla y Petalos de Rosa', 'Perfume sólido floral de frutilla y rosa', 38.00, 24.00, 30, 'zpr36.jpeg', 'Activo'),
(37, 'Perfume Solido de Vainilla y Flores Blancas', 'Perfume sólido de vainilla y flores', 38.00, 24.00, 30, 'zpr37.jpeg', 'Activo'),
(38, 'Perfume Solido de Jazmin', 'Perfume sólido de jazmín', 35.00, 22.00, 30, 'zpr39.jpeg', 'Activo'),
(39, 'Polvo Maiz Morado', 'Polvo facial de maíz morado', 18.00, 11.00, 30, 'zpr17.jpeg', 'Activo'),
(40, 'Polvo Arcilla Rosada', 'Polvo facial de arcilla rosada', 20.00, 12.00, 30, 'zpr40.jpeg', 'Activo'),
(41, 'Polvo Te Verde', 'Polvo facial de té verde', 18.00, 11.00, 30, 'zpr42.jpeg', 'Activo'),
(42, 'Polvo Avena Coloidal', 'Polvo facial de avena coloidal', 17.00, 10.00, 30, 'zpr41.jpeg', 'Activo'),
(43, 'Polvo de Remolacha', 'Polvo natural de remolacha', 18.00, 11.00, 30, 'zpr43.jpeg', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imagen_perfil` varchar(255) DEFAULT 'imgperfil.avif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`, `fecha`, `imagen_perfil`) VALUES
(9463748, 'Angie', 'angie@gmail.com', 62731919, 'administrador', 'activo', '2026-09-08 14:08:43', 'imgperfil.avif'),
(13969703, 'Scherezade', 'scherezade@gmail.com', 69957473, 'administrador', 'activo', '2026-09-08 14:08:43', 'imgperfil.avif'),
(12372096, 'Jessenia', 'jessenia@gmail.com', 62731772, 'administrador', 'activo', '2026-09-08 14:08:43', 'imgperfil.avif'),
(13875379, 'Nahia', 'nahia@gmail.com', 68487759, 'administrador', 'activo', '2026-09-08 14:08:43', 'imgperfil.avif'),
(10000008, 'lorena', 'Av. Mariscal Santa Cruz', 78889900, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000009, 'maria', 'Calle Linares #44', 79990011, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000010, 'denis', 'Av. Buenos Aires 990', 60001122, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000011, 'carmelita', 'Zona Miraflores #12', 61112233, 'usuario', 'inactivo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000012, 'valentina', 'Calle Illampu 777', 62223344, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000004, 'veliz', 'Av. Arce 555', 74445566, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000001, 'isabella', 'Av. Villazón 1024', 71223344, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000002, 'paola', 'Calle Jordan 456', 72334455, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000003, 'pepi', 'Calle Murillo 102', 73334455, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000003, 'claudia', 'Zona Calacoto, Calle 15', 73445566, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000002, 'pablo', 'Av. 6 de Agosto 789', 72223344, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000004, 'alejandra', 'Av. Blanco Galindo Km 4', 74556677, 'usuario', 'inactivo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000005, 'carolina', 'Calle Ayacucho 712', 75667788, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000006, 'tatiana', 'Av. Banzer, Condominio El Bosque', 76778899, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000007, 'veronica', 'Zona Achumani, Calle 22', 77889900, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000007, 'josue', 'Calle Sagárnaga #88', 77778899, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000008, 'raquel', 'Calle San Martín 380', 78990011, 'usuario', 'inactivo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000005, 'pampeño', 'Zona Sur, Calle 21', 75556677, 'usuario', 'inactivo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000009, 'vanessa', 'Av. Las Américas #89', 79001122, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000001, 'machaca', 'Calle Potosí 456', 71112233, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(30000010, 'elizabeth', 'Zona Equipetrol, Calle 5', 60112233, 'usuario', 'activo', '2026-09-08 10:12:18', 'imgperfil.avif'),
(10000008, 'lorena', 'Av. Mariscal Santa Cruz', 78889900, 'usuario', 'activo', '2025-01-15 09:24:00', 'imgperfil.avif'),
(10000009, 'maria', 'Calle Linares #44', 79990011, 'usuario', 'activo', '2025-02-03 14:17:00', 'imgperfil.avif'),
(10000010, 'denis', 'Av. Buenos Aires 990', 60001122, 'usuario', 'activo', '2025-02-21 10:42:00', 'imgperfil.avif'),
(10000011, 'carmelita', 'Zona Miraflores #12', 61112233, 'usuario', 'inactivo', '2025-03-08 16:35:00', 'imgperfil.avif'),
(10000012, 'valentina', 'Calle Illampu 777', 62223344, 'usuario', 'activo', '2025-03-27 11:08:00', 'imgperfil.avif'),
(10000004, 'veliz', 'Av. Arce 555', 74445566, 'usuario', 'activo', '2025-04-12 08:51:00', 'imgperfil.avif'),
(30000001, 'isabella', 'Av. Villazón 1024', 71223344, 'usuario', 'activo', '2025-04-29 13:26:00', 'imgperfil.avif'),
(30000002, 'paola', 'Calle Jordan 456', 72334455, 'usuario', 'activo', '2025-05-16 15:44:00', 'imgperfil.avif'),
(10000003, 'pepi', 'Calle Murillo 102', 73334455, 'usuario', 'activo', '2025-06-02 09:13:00', 'imgperfil.avif'),
(30000003, 'claudia', 'Zona Calacoto, Calle 15', 73445566, 'usuario', 'activo', '2025-06-19 17:22:00', 'imgperfil.avif'),
(10000002, 'pablo', 'Av. 6 de Agosto 789', 72223344, 'usuario', 'activo', '2025-07-05 10:37:00', 'imgperfil.avif'),
(30000004, 'alejandra', 'Av. Blanco Galindo Km 4', 74556677, 'usuario', 'inactivo', '2025-07-23 12:49:00', 'imgperfil.avif'),
(30000005, 'carolina', 'Calle Ayacucho 712', 75667788, 'usuario', 'activo', '2025-08-11 14:05:00', 'imgperfil.avif'),
(30000006, 'tatiana', 'Av. Banzer, Condominio El Bosque', 76778899, 'usuario', 'activo', '2025-08-28 09:56:00', 'imgperfil.avif'),
(30000007, 'veronica', 'Zona Achumani, Calle 22', 77889900, 'usuario', 'activo', '2025-09-14 16:18:00', 'imgperfil.avif'),
(10000007, 'josue', 'Calle Sagárnaga #88', 77778899, 'usuario', 'activo', '2025-10-01 11:31:00', 'imgperfil.avif'),
(30000008, 'raquel', 'Calle San Martín 380', 78990011, 'usuario', 'inactivo', '2025-10-19 13:47:00', 'imgperfil.avif'),
(10000005, 'pampeño', 'Zona Sur, Calle 21', 75556677, 'usuario', 'inactivo', '2025-11-06 08:29:00', 'imgperfil.avif'),
(30000009, 'vanessa', 'Av. Las Américas #89', 79001122, 'usuario', 'activo', '2025-11-24 15:12:00', 'imgperfil.avif'),
(10000001, 'machaca', 'Calle Potosí 456', 71112233, 'usuario', 'activo', '2025-12-09 10:06:00', 'imgperfil.avif'),
(30000010, 'elizabeth', 'Zona Equipetrol, Calle 5', 60112233, 'usuario', 'activo', '2026-01-18 14:38:00', 'imgperfil.avif'),
(10000006, 'sebastian', 'Av. Bush 321', 76667788, 'usuario', 'activo', '2026-02-07 09:45:00', 'imgperfil.avif'),
(40000001, 'fabricia', 'Av. Mutualista 450', 71334455, 'usuario', 'activo', '2026-02-25 16:21:00', 'imgperfil.avif'),
(40000002, 'leonarda', 'Calle Bolívar 890', 72445566, 'usuario', 'activo', '2026-03-13 11:54:00', 'imgperfil.avif'),
(40000003, 'matea', 'Zona Sopocachi, Calle Aspiazu', 73556677, 'usuario', 'inactivo', '2026-04-02 13:16:00', 'imgperfil.avif'),
(2147483647, 'machaca', 'rojas@gmail.com', 2147483647, 'usuario', 'activo', '2026-09-08 10:13:57', 'imgperfil.avif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  `costo` decimal(10,2) DEFAULT 0.00,
  `metodo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ventas_pedido` (`pedidos_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
