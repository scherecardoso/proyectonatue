-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2026 at 05:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shena`
--

-- --------------------------------------------------------

--
-- Table structure for table `carrito`
--

CREATE TABLE `carrito` (
  `pedidos_id` int(11) NOT NULL,
  `productos_codigo` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT 1,
  `costototal` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carrito`
--

INSERT INTO `carrito` (`pedidos_id`, `productos_codigo`, `cantidad`, `costototal`) VALUES
(0, 1, 1, 45.00),
(0, 6, 1, 35.00),
(0, 14, 1, 42.00),
(0, 23, 1, 28.00),
(0, 27, 1, 29.00),
(0, 32, 1, 22.00),
(2, 39, 1, 18.00),
(2, 40, 1, 20.00),
(2, 37, 1, 38.00),
(2, 36, 1, 38.00),
(2, 42, 1, 17.00),
(2, 19, 1, 20.00),
(2, 1, 2, 90.00),
(3, 5, 1, 47.00),
(3, 4, 1, 40.00),
(3, 3, 1, 48.00),
(3, 24, 1, 30.00),
(3, 23, 1, 28.00),
(3, 29, 4, 80.00),
(3, 27, 1, 29.00),
(3, 21, 1, 20.00),
(3, 22, 1, 22.00),
(3, 26, 1, 27.00),
(4, 3, 2, 96.00),
(4, 2, 1, 55.00),
(4, 5, 1, 47.00),
(5, 1, 2, 90.00),
(6, 38, 1, 35.00),
(6, 37, 1, 38.00),
(6, 43, 1, 18.00),
(6, 42, 1, 17.00),
(6, 39, 1, 18.00),
(7, 1, 1, 45.00),
(7, 33, 1, 20.00),
(7, 32, 1, 22.00),
(7, 40, 1, 20.00),
(7, 42, 1, 17.00),
(7, 19, 1, 20.00),
(7, 16, 1, 34.00),
(7, 14, 1, 42.00),
(7, 6, 1, 35.00),
(8, 5, 1, 47.00),
(8, 4, 1, 40.00),
(8, 3, 1, 48.00),
(8, 13, 1, 30.00),
(8, 17, 1, 39.00),
(8, 18, 1, 18.00),
(8, 11, 1, 38.00),
(8, 16, 1, 34.00),
(9, 1, 1, 45.00),
(9, 3, 1, 48.00),
(9, 4, 1, 40.00),
(9, 29, 1, 20.00),
(9, 27, 1, 29.00),
(10, 5, 1, 47.00),
(11, 5, 1, 47.00),
(11, 1, 1, 45.00),
(12, 4, 1, 40.00),
(12, 3, 1, 48.00),
(13, 3, 1, 48.00),
(13, 2, 1, 55.00),
(14, 5, 1, 47.00),
(14, 1, 1, 45.00),
(14, 39, 1, 18.00),
(14, 40, 1, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `favoritos`
--

CREATE TABLE `favoritos` (
  `ci` int(11) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favoritos`
--

INSERT INTO `favoritos` (`ci`, `codigo`) VALUES
(13950742, 3),
(13950742, 4),
(13950742, 2),
(13950742, 1),
(13950742, 5),
(13950742, 7),
(13950742, 16),
(13950742, 20);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
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

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `nombre`, `fecha`, `estado`, `vendedor`, `telefono`, `direccion`, `metodoPago`) VALUES
(1, 'Isabella', '2026-09-19', 'Rechazado', 'Sin asignar', '60539067', 'Av. América Oeste #245', 'Efectivo'),
(2, 'Camila', '2026-09-19', 'Aceptado', 'Rafa', '97745026', 'Calle Aniceto Padilla #318', 'Tarjeta'),
(3, 'Camila', '2026-09-19', 'Aceptado', 'Gabriela', '97745026', 'cam@gmail.com', 'QR'),
(4, 'Camila', '2026-09-19', 'Aceptado', 'Rafa', '97745026', 'cam@gmail.com', 'Tarjeta'),
(5, 'Dania', '2026-09-19', 'Rechazado', 'Sin asignar', '95734969', 'dania@gmail.com', 'Efectivo'),
(6, 'Sofia', '2026-09-19', 'Aceptado', 'Fernanda', '49673585', 'sofii@gmail.com', 'Efectivo'),
(7, 'Valeria', '2026-09-19', 'Aceptado', 'Lucía', '70585430', 'val@gmail.com', 'Efectivo'),
(8, 'Valeria', '2026-09-19', 'Aceptado', 'Lucía', '70585430', 'Av. Circunvalación #892', 'Efectivo'),
(9, 'Belen', '2026-09-19', 'Aceptado', 'Gabriela', '74597748', 'Calle Quijarro #421', 'Efectivo'),
(10, 'Belen', '2026-09-19', 'Aceptado', 'Gabriela', '74597748', 'Av. Santa Cruz #643', 'Efectivo'),
(11, 'lorena', '2026-09-19', 'Aceptado', 'Rafa', '56997643', 'Calle Baptista #379', 'Tarjeta'),
(12, 'Fabiana', '2026-09-19', 'Aceptado', 'Rafa', '69673579', 'Calle Sucre #345', 'Efectivo'),
(13, 'Nicole', '2026-09-19', 'Aceptado', 'Rafa', '37856536', 'Calle Jordana #193', 'Efectivo'),
(14, 'Emma', '2026-09-19', 'Aceptado', 'Gabriela', '46676770', 'Av. Melchor Pérez #456', 'Efectivo');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
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
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `precio`, `costo`, `stock`, `imagen`, `estado`) VALUES
(1, 'Serum de Coco', 'Serum hidratante de coco', 45.00, 30.00, 24, 'zpr2.jpeg', 'Activo'),
(2, 'Despigmentante de Achachairu', 'Despigmentante natural de Achachairu', 55.00, 40.00, 28, 'zpr6.jpeg', 'Activo'),
(3, 'Serum de Tamarindo', 'Serum natural de tamarindo', 48.00, 35.00, 23, 'zpr19.jpeg', 'Activo'),
(4, 'Aceite Antiestres de Cacao', 'Aceite relajante de cacao', 40.00, 28.00, 26, 'zpr16.jpeg', 'Activo'),
(5, 'Serum de Chirimoya', 'Serum de chirimoya para la piel', 47.00, 34.00, 24, 'zpr18.jpeg', 'Activo'),
(6, 'Flores de Kantuta', 'Producto natural de flores de kantuta', 35.00, 22.00, 29, 'zpr21.jpeg', 'Activo'),
(7, 'Aceite de Copaiba', 'Aceite natural de copaiba', 50.00, 36.00, 30, 'zpr22.jpeg', 'Activo'),
(8, 'Gel de Quinua', 'Gel natural de quinua', 33.00, 20.00, 30, 'zpr11.jpeg', 'Activo'),
(9, 'Gel de Pepino', 'Gel refrescante de pepino', 30.00, 18.00, 30, 'zpr5.jpeg', 'Activo'),
(10, 'Gel de Sabila', 'Gel de sábila hidratante', 28.00, 16.00, 30, 'zpr7.jpeg', 'Activo'),
(11, 'Aceite de Coco', 'Aceite natural de coco', 38.00, 25.00, 29, 'zpr14.jpeg', 'Activo'),
(12, 'Bruma de Eucalipto', 'Bruma refrescante de eucalipto', 32.00, 20.00, 30, 'zpr24.jpeg', 'Activo'),
(13, 'Suavizante de Papaya', 'Suavizante natural de papaya', 30.00, 18.00, 29, 'zpr3.jpeg', 'Activo'),
(14, 'Balsamo de Matico', 'Bálsamo de matico', 42.00, 28.00, 29, 'zpr4.jpeg', 'Activo'),
(15, 'Crema de Maracuya y Sabila', 'Crema natural de maracuyá y sábila', 37.00, 24.00, 30, 'zpr8.jpeg', 'Activo'),
(16, 'Exfoliante de Cafe', 'Exfoliante natural de café', 34.00, 22.00, 28, 'zpr23.jpeg', 'Activo'),
(17, 'Crema Matificante', 'Crema matificante facial', 39.00, 26.00, 29, 'zpr25.jpeg', 'Activo'),
(18, 'Jabon de Semilla de Tarwi', 'Jabón de tarwi', 18.00, 10.00, 29, 'zpr9.jpeg', 'Activo'),
(19, 'Jabon de Avena y Miel', 'Jabón de avena y miel', 20.00, 12.00, 28, 'zpr44.jpeg', 'Activo'),
(20, 'Jabon de Rosa Mosqueta', 'Jabón de rosa mosqueta', 22.00, 14.00, 30, 'zpr45.jpeg', 'Activo'),
(21, 'Jabon de Curcuma y Manzanilla', 'Jabón de cúrcuma y manzanilla', 20.00, 12.00, 29, 'zpr46.jpeg', 'Activo'),
(22, 'Jabon de Carbon Activado', 'Jabón de carbón activado', 22.00, 14.00, 29, 'zpr47.jpeg', 'Activo'),
(23, 'Desmaquillante de Chia', 'Desmaquillante natural de chia', 28.00, 18.00, 29, 'zpr1.jpeg', 'Activo'),
(24, 'Desmaquillante de Manzanilla y Avena', 'Desmaquillante natural de manzanilla y avena', 30.00, 19.00, 29, 'zpr34.jpeg', 'Activo'),
(25, 'Desmaquillante de Uva Morada', 'Desmaquillante natural de uva morada', 32.00, 20.00, 30, 'zpr33.jpeg', 'Activo'),
(26, 'Desmaquillante de Pepino', 'Desmaquillante refrescante de pepino', 27.00, 17.00, 29, 'zpr31.jpeg', 'Activo'),
(27, 'Desmaquillante Leche de Coco', 'Desmaquillante nutritivo de leche de coco', 29.00, 18.00, 28, 'zpr32.jpeg', 'Activo'),
(28, 'Desmaquillante de Agua de Rosas', 'Desmaquillante de agua de rosas', 28.00, 18.00, 30, 'zpr30.jpeg', 'Activo'),
(29, 'Balsamo de Castaña', 'Bálsamo nutritivo de castaña', 20.00, 12.00, 25, 'zpr12.jpeg', 'Activo'),
(30, 'Balsamo de Frambuesa', 'Bálsamo de frambuesa', 20.00, 12.00, 30, 'zpr27.jpeg', 'Activo'),
(31, 'Balsamo de Maracuya', 'Bálsamo de maracuyá', 20.00, 12.00, 30, 'zpr28.jpeg', 'Activo'),
(32, 'Balsamo de Vainilla y Coco', 'Bálsamo de vainilla y coco', 22.00, 13.00, 29, 'zpr29.jpeg', 'Activo'),
(33, 'Balsamo de Frutilla', 'Bálsamo de frutilla', 20.00, 12.00, 29, 'zpr26.jpeg', 'Activo'),
(34, 'Perfume Solido de Orquidea', 'Perfume sólido de orquídea', 35.00, 22.00, 30, 'zpr13.jpeg', 'Activo'),
(35, 'Perfume Solido de Bergamota', 'Perfume sólido de bergamota', 35.00, 22.00, 30, 'zpr35.jpeg', 'Activo'),
(36, 'Perfume Solido de Frutilla y Petalos de Rosa', 'Perfume sólido floral de frutilla y rosa', 38.00, 24.00, 29, 'zpr36.jpeg', 'Activo'),
(37, 'Perfume Solido de Vainilla y Flores Blancas', 'Perfume sólido de vainilla y flores', 38.00, 24.00, 28, 'zpr37.jpeg', 'Activo'),
(38, 'Perfume Solido de Jazmin', 'Perfume sólido de jazmín', 35.00, 22.00, 29, 'zpr39.jpeg', 'Activo'),
(39, 'Polvo Maiz Morado', 'Polvo facial de maíz morado', 18.00, 11.00, 27, 'zpr17.jpeg', 'Activo'),
(40, 'Polvo Arcilla Rosada', 'Polvo facial de arcilla rosada', 20.00, 12.00, 27, 'zpr40.jpeg', 'Activo'),
(41, 'Polvo Te Verde', 'Polvo facial de té verde', 18.00, 11.00, 30, 'zpr42.jpeg', 'Activo'),
(42, 'Polvo Avena Coloidal', 'Polvo facial de avena coloidal', 17.00, 10.00, 27, 'zpr41.jpeg', 'Activo'),
(43, 'Polvo de Remolacha', 'Polvo natural de remolacha', 18.00, 11.00, 29, 'zpr43.jpeg', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `rol` varchar(45) NOT NULL DEFAULT 'usuario',
  `estado` varchar(45) NOT NULL DEFAULT 'activo',
  `fecha` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imagen_perfil` varchar(255) DEFAULT 'imgperfil.avif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`, `fecha`, `imagen_perfil`) VALUES
(9463748, 'Angie', 'angie@gmail.com', 62731919, 'administrador', 'activo', '2026-09-19 22:36:09', 'perfil-Angie.png'),
(13969703, 'Scherezade', 'scherezade@gmail.com', 69957473, 'administrador', 'activo', '2026-09-19 22:36:44', 'perfil-Scherezade.png'),
(12372096, 'Jessenia', 'jessenia@gmail.com', 62731772, 'administrador', 'activo', '2026-09-19 22:37:13', 'perfil-Jessenia.png'),
(13875379, 'Nahia', 'nahia@gmail.com', 68487759, 'administrador', 'activo', '2026-09-11 22:36:26', 'perfil-Nahia.png'),
(17482635, 'Isabella', 'isabella@gmail.com', 60539067, 'usuario', 'activo', '2026-09-19 22:19:04', 'imgperfil.avif'),
(13950742, 'Camila', 'cam@gmail.com', 97745026, 'usuario', 'activo', '2026-09-19 22:19:31', 'imgperfil.avif'),
(18536490, 'Dania', 'dania@gmail.com', 95734969, 'usuario', 'activo', '2026-09-19 22:24:49', 'imgperfil.avif'),
(12694853, 'Sofia', 'sofii@gmail.com', 49673585, 'usuario', 'activo', '2026-09-19 22:25:50', 'imgperfil.avif'),
(19730584, 'Valeria', 'val@gmail.com', 70585430, 'usuario', 'activo', '2026-09-19 22:26:25', 'imgperfil.avif'),
(14382761, 'Belen', 'belen@gmail.com', 74597748, 'usuario', 'activo', '2026-09-19 22:26:58', 'imgperfil.avif'),
(16859204, 'lorena', 'lore@gmail.com', 56997643, 'usuario', 'activo', '2026-09-19 22:27:33', 'imgperfil.avif'),
(11573486, 'Fabiana', 'fabi@gmail.com', 69673579, 'usuario', 'activo', '2026-09-19 22:28:27', 'imgperfil.avif'),
(18264937, 'Nicole', 'nicole@gmail.com', 37856536, 'usuario', 'activo', '2026-09-19 22:29:32', 'imgperfil.avif'),
(15420869, 'Emma', 'emma@gmail.com', 46676770, 'usuario', 'activo', '2026-09-19 22:29:57', 'imgperfil.avif'),
(10937524, 'Gabriela', 'gabi@gmail.com', 89773496, 'vendedor', 'activo', '2026-09-19 22:34:13', 'imgperfil.avif'),
(17643095, 'Lucía', 'lucia@gmail.com', 98748221, 'vendedor', 'activo', '2026-09-19 22:34:13', 'imgperfil.avif'),
(13278541, 'Rafa', 'rafa@gmail.com', 96735769, 'vendedor', 'activo', '2026-09-19 22:34:13', 'imgperfil.avif'),
(19462173, 'Fernanda', 'fernanda@gmail.com', 94725750, 'vendedor', 'activo', '2026-09-19 22:34:13', 'imgperfil.avif');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  `costo` decimal(10,2) DEFAULT 0.00,
  `metodo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `pedidos_id`, `costo`, `metodo`, `estado`, `fecha`) VALUES
(30, 14, 130.00, 'Efectivo', 'En proceso', '2026-09-19 23:04:22'),
(31, 9, 182.00, 'Efectivo', 'En proceso', '2026-09-19 23:04:28'),
(32, 3, 371.00, 'QR', 'En proceso', '2026-09-19 23:04:41'),
(33, 10, 47.00, 'Efectivo', 'En proceso', '2026-09-19 23:04:52'),
(34, 8, 294.00, 'Efectivo', 'En proceso', '2026-09-19 23:05:28'),
(35, 7, 255.00, 'Efectivo', 'En proceso', '2026-09-19 23:05:31'),
(36, 4, 198.00, 'Tarjeta', 'En proceso', '2026-09-19 23:05:52'),
(37, 12, 88.00, 'Efectivo', 'En proceso', '2026-09-19 23:05:55'),
(38, 11, 92.00, 'Tarjeta', 'En proceso', '2026-09-19 23:06:01'),
(39, 13, 103.00, 'Efectivo', 'En proceso', '2026-09-19 23:06:04'),
(40, 2, 241.00, 'Tarjeta', 'En proceso', '2026-09-19 23:06:14'),
(41, 6, 126.00, 'Efectivo', 'En proceso', '2026-09-19 23:06:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
