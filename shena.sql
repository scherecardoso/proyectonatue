-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 04:34 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `cantidad` int(11) DEFAULT NULL,
  `costototal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `carrito`
--

INSERT INTO `carrito` (`pedidos_id`, `productos_codigo`, `cantidad`, `costototal`) VALUES
(1, 1, 2, 90),
(1, 2, 1, 55),
(1, 3, 2, 96),
(3, 1, 1, 45),
(4, 1, 2, 90);

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `vendedor` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `nombre`, `fecha`, `estado`, `vendedor`) VALUES
(1, 'daniela', '2026-06-30', 'Pendiente', 'Administrador'),
(2, 'wewdaweaw', '2026-06-30', 'En Proceso', 'daniela'),
(3, 'daniela', '2026-06-30', 'Pendiente', 'Administrador'),
(4, 'daniela', '2026-06-30', 'En Proceso', 'Administrador'),
(5, 'e23e32e', '2026-06-30', 'En Proceso', 'daniela');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `precio`, `costo`, `stock`) VALUES
(1, 'Serum de Coco', 'Serum hidratante de coco', 45, 30, 20),
(2, 'Despigmentante de Achachairu', 'Despigmentante natural de Achachairu', 55, 40, 20),
(3, 'Serum de Tamarindo', 'Serum natural de tamarindo', 48, 35, 20),
(4, 'Aceite Antiestres de Cacao', 'Aceite relajante de cacao', 40, 28, 20),
(5, 'Serum de Chirimoya', 'Serum de chirimoya para la piel', 47, 34, 20),
(6, 'Flores de Kantuta', 'Producto natural de flores de kantuta', 35, 22, 20),
(7, 'Aceite de Copaiba', 'Aceite natural de copaiba', 50, 36, 20),
(8, 'Gel de Quinua', 'Gel natural de quinua', 33, 20, 20),
(9, 'Gel de Pepino', 'Gel refrescante de pepino', 30, 18, 20),
(10, 'Gel de Sabila', 'Gel de sábila hidratante', 28, 16, 20),
(11, 'Aceite de Coco', 'Aceite natural de coco', 38, 25, 20),
(12, 'Bruma de Eucalipto', 'Bruma refrescante de eucalipto', 32, 20, 20),
(13, 'Suavizante de Papaya', 'Suavizante natural de papaya', 30, 18, 20),
(14, 'Balsamo de Matico', 'Bálsamo de matico', 42, 28, 20),
(15, 'Crema de Maracuya y Sabila', 'Crema natural de maracuyá y sábila', 37, 24, 20),
(16, 'Exfoliante de Cafe', 'Exfoliante natural de café', 34, 22, 20),
(17, 'Crema Matificante', 'Crema matificante facial', 39, 26, 20),
(18, 'Jabon de Semilla de Tarwi', 'Jabón de tarwi', 18, 10, 20),
(19, 'Jabon de Avena y Miel', 'Jabón de avena y miel', 20, 12, 20),
(20, 'Jabon de Rosa Mosqueta', 'Jabón de rosa mosqueta', 22, 14, 20),
(21, 'Jabon de Curcuma y Manzanilla', 'Jabón de cúrcuma y manzanilla', 20, 12, 20),
(22, 'Jabon de Carbon Activado', 'Jabón de carbón activado', 22, 14, 20);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `CI` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `direccion` varchar(45) DEFAULT NULL,
  `celular` int(11) DEFAULT NULL,
  `rol` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`CI`, `nombre`, `direccion`, `celular`, `rol`, `estado`) VALUES
(12345678, 'daniela', 'daniela@gmail.com', 12345678, 'usuario', 'activo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`pedidos_id`,`productos_codigo`),
  ADD KEY `fk_pedidos_has_productos_productos1_idx` (`productos_codigo`),
  ADD KEY `fk_pedidos_has_productos_pedidos_idx` (`pedidos_id`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CI`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_pedidos_has_productos_pedidos` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pedidos_has_productos_productos1` FOREIGN KEY (`productos_codigo`) REFERENCES `productos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
