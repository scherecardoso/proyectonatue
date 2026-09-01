-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-09-2026 a las 16:47:28
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
(12345678, 'pepa', 'aguilarcortezisabel@pedropoveda.edu.bo', 12345678, 'usuario', 'bfxgchdgjh', '2026-08-28 11:15:45', 'imgperfil.avif');

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
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`pedidos_id`,`productos_codigo`),
  ADD KEY `fk_carrito_producto` (`productos_codigo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`);
ALTER TABLE `productos` ADD FULLTEXT KEY `imagen` (`imagen`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`CI`);

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
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_pedido` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `fk_carrito_producto` FOREIGN KEY (`productos_codigo`) REFERENCES `productos` (`codigo`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_pedido` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
