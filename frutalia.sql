-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2023 a las 00:35:41
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `frutalia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Jarabe', 'Descripción de categoría jarabe'),
(2, 'Gelatina', 'Descripción de categoría Gelatina'),
(3, 'Polvo', 'Descripción de categoría Polvo'),
(4, 'Esencia', 'Descripción de categoría Esencia'),
(5, 'Sin Categoría', 'Descripción de Sin Categoría');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden`
--

CREATE TABLE `detalle_orden` (
  `id` int(11) NOT NULL,
  `orden_id` int(11) DEFAULT NULL,
  `producto_id` int(11) UNSIGNED DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_orden`
--

INSERT INTO `detalle_orden` (`id`, `orden_id`, `producto_id`, `cantidad`) VALUES
(38, 53, 8, 4),
(39, 53, 9, 1),
(40, 53, 3, 1),
(41, 53, 2, 1),
(42, 54, 4, 1),
(43, 54, 5, 2),
(45, 56, 3, 2),
(46, 56, 12, 3),
(47, 57, 12, 3),
(48, 58, 11, 1),
(49, 58, 12, 1),
(50, 58, 2, 1),
(51, 59, 12, 2),
(52, 59, 11, 3),
(55, 61, 3, 3),
(56, 61, 4, 2),
(60, 63, 3, 3),
(61, 63, 6, 3),
(62, 64, 2, 1),
(63, 64, 3, 2),
(64, 64, 5, 2),
(65, 64, 4, 1),
(66, 64, 11, 1),
(67, 65, 10, 1),
(68, 65, 12, 1),
(69, 65, 9, 1),
(70, 65, 11, 1),
(71, 65, 7, 1),
(72, 65, 2, 1),
(73, 65, 3, 1),
(74, 65, 6, 1),
(75, 65, 5, 1),
(76, 66, 5, 2),
(77, 66, 3, 1),
(79, 68, 12, 1),
(80, 68, 9, 1),
(81, 68, 7, 1),
(90, 83, 1, 3),
(91, 83, 11, 1),
(92, 83, 3, 2),
(93, 83, 4, 2),
(94, 84, 1, 2),
(95, 84, 2, 2),
(96, 84, 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id`, `nombre`) VALUES
(1, 'Pendiente'),
(2, 'Por Entregar'),
(3, 'Pagado'),
(4, 'Entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estatus_id` int(11) UNSIGNED DEFAULT NULL,
  `usuario_id` int(11) UNSIGNED DEFAULT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `cantidad`, `total`, `estatus_id`, `usuario_id`, `metodo_pago`, `direccion`, `telefono`, `created_at`) VALUES
(53, 7, 106.91, 2, 20, 'Transferencia', '555', '546545', '2023-11-22'),
(54, 3, 138.84, 1, 20, 'Pago Móvil', '3333', '4444444', '2023-11-22'),
(58, 3, 78.00, 1, 22, 'Pago Móvil', '', '', '2023-11-22'),
(59, 5, 136.00, 4, 22, 'Transferencia', 'La Guaira, el trebol quinta #4', '04160008877', '2023-11-22'),
(61, 5, 166.05, 4, 1, 'Transferencia', 'Catia los magallanes casa #8', '04242227845', '2023-11-22'),
(63, 6, 172.05, 4, 23, 'Transferencia', '2 x 3 productos prueba', '', '2023-11-22'),
(64, 7, 269.54, 4, 14, 'Transferencia', 'Catia Urb lomas de urdaneta', '04142931360', '2023-11-22'),
(65, 9, 227.40, 2, 15, 'Transferencia', 'Vista Alegre calle 12 qta mi abuela', '04241221419', '2023-11-22'),
(68, 3, 56.13, 2, 26, 'Transferencia', 'mi casa amarilla', '02121234785', '2023-11-25'),
(83, 8, 155.13, 2, 24, 'Transferencia', '', '', '2023-11-25'),
(84, 7, 94.62, 1, 24, 'Pago Móvil', 'El Cafetal calle san luis', '04124799687', '2023-11-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `banco` varchar(50) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `referencia` int(8) NOT NULL,
  `fecha` date NOT NULL,
  `estatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `orden_id`, `banco`, `monto`, `referencia`, `fecha`, `estatus`) VALUES
(1, 53, 'Banco Venezuela', 106.91, 45000102, '2023-11-22', 'Aprobado'),
(3, 59, 'Banesco', 136.00, 794505, '2023-11-22', 'Aprobado'),
(4, 61, 'Bancamiga', 166.05, 1020407, '2023-11-22', 'Aprobado'),
(5, 63, 'Banco Venezuela', 172.05, 79651205, '2023-11-22', 'Aprobado'),
(6, 64, 'Bancamiga', 269.54, 3659871, '2023-11-22', 'Aprobado'),
(7, 65, 'Bancamiga', 227.40, 2314656, '2023-11-22', 'Aprobado'),
(9, 68, 'Banco Venezuela', 56.13, 120045, '2023-11-25', 'Aprobado'),
(10, 83, 'Banesco', 155.13, 45780069, '2023-11-25', 'Aprobado'),
(11, 84, 'Pago Móvil', 94.62, 7845, '2023-11-25', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `detalle` varchar(255) NOT NULL,
  `descripción` text NOT NULL,
  `id_categoria` int(11) UNSIGNED DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(10) NOT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `detalle`, `descripción`, `id_categoria`, `precio`, `stock`, `imagen`) VALUES
(1, ' Colorante Amarillo', '1 Litro', 'Colorante amarillo frutalia, disponible en presentaciones de litro, gal&oacute;n y cu&ntilde;ete.', 3, 4.81, 34, 'colorante_amarillo.png'),
(2, ' Gelatina Limon', '5Kg', 'Mezcla para hacer gelatina con sabor a lim&oacute;n', 2, 20.00, 20, 'gelatina_limon.png'),
(3, ' Choco Polvo', '10Kg', 'Chocolate en polvo dulce, saco de 10 kilos', 3, 45.35, 20, 'choco_polvo.png'),
(4, ' Mezcla de Helado', '5Kg', 'Mezcla para hacer helado sabor a fresa', 3, 15.00, 20, 'helado_fresa.png'),
(5, ' Vainilla en Polvo', '10Kg', 'Vainilla en polvo, saco de 10 kilos', 3, 61.92, 20, 'vainilla_polvo.png'),
(6, ' Ron Jamaica', '1L', 'Esencia de Ron Jamaica, presentaci&oacute;n de 1 litro', 4, 12.00, 20, 'ron_jamaica.png'),
(7, ' Vainilla Blanca', '1 Litro', 'Esencia de vainilla sin color', 4, 8.13, 20, 'vainilla_blanca.png'),
(8, ' Vainilla Negra', '1 Litro', 'Esencia de vainilla negra', 4, 7.89, 2, 'vainilla_negra.png'),
(9, ' Polviazúcar', '5kg', 'Az&uacute;car finamente pulverizada', 3, 10.00, 20, 'polviazucar.png'),
(10, ' Flan de Vainilla', '5kg', 'Mezcla en polvo para preparar flan sabor a vainilla', 3, 12.00, 10, 'flan_vainilla.png'),
(11, 'Gelatina Frambuesa', '5kg', 'Mezcla para hacer gelatina sabor frambuesa', 2, 20.00, 14, 'gelatina_frambuesa.png'),
(12, ' Gelatina Fresa', '10Kg', 'Mezcla para hacer gelatina sabor a mora', 2, 38.00, 8, 'gelatina_fresa.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellido`, `usuario`, `email`, `contraseña`, `avatar`, `is_admin`) VALUES
(1, 'Alejandro', 'Montes', 'amontes', 'alejandro_montes@gmail.com', '$2y$10$m7/oznjxDeSHIIZE9/ykAef7ZsbyTZGMgShrJ9YyB5505yKURds/W', '1700583478avatar15.jpg', 0),
(14, 'Gabriela', 'Patiño', 'Gabyp05', 'gabyapd05@gmail.com', '$2y$10$UgNZvLGOTq68om1wvuLMSeCOWHpQ5eQVhVMAKD.bWwq2gMPKzjFxi', '1695510760avatar9.jpg', 0),
(15, 'Richard', 'Patiño', 'rapd24', 'rapd@gmail.com', '$2y$10$.1DOGOQM0k3UKbUrEyonwOUF0v5Kcx75qjUnqXKY5rAL.9Fm.nz0C', '1695585894avatar13.jpg', 0),
(16, 'Frutalia', 'C.A', 'admin', 'admin@frutalia.com', '$2y$10$.KIstCtRWpgaYwuoRHAD7un/kja6e.jc.yg9Ui53x07ItHPR1sSjy', '1695586691FRUTALIA-LOGO-03-azul-3-180x180.png', 1),
(18, 'Otro', 'Patiño', 'Otro', 'otro@gmaill.com', '$2y$10$xO7VW0VfhrawUHMAIJR.8..J90aSCWfTw0hAFapaZI.bjvYu.TF9O', '1695588317avatar14.jpg', 0),
(19, 'Nuevo', 'Usuario', 'User3', 'gabaa@gmail.com', '$2y$10$3w/WEQ9ORTRd2XIP4IlP7ur.Rn482ooRkxszzBXs.5OXFBOCoIDLO', '1695588460avatar8.jpg', 0),
(20, 'Geraldine', 'Díaz', 'Yera2012', 'geralex1971@gmail.com', '$2y$10$PSBw8lrLGGuzT27vRj/lRuWLu1NnZA.UHCWsVT7oKt8KLMN1tyq12', '1696982685avatar6.jpg', 0),
(21, 'Pepito', 'Perez', 'pepe', 'pepe@gmail.com', '$2y$10$UrlcPKmgZWLlKvmRqxOLr.Eh/VFaUiBJTv0E3OtS.nSb2pA4mqeAa', '1700601142avatar11.jpg', 0),
(22, 'Maria', 'Ventana', 'maria', 'mariaventana@gmail.com', '$2y$10$KmhVuvvU6u82q8njO6K.DumJiJRd6e/ojp0w56LuQwzKroqLIIqlq', '1700665786avatar4.jpg', 0),
(23, 'Juanito', 'Alimaña', 'juanito', 'juanalimana@gmail.com', '$2y$10$QLNlq3yGj8Mqu9IVDddzruMPh9k8lXvlxRZ8B9QXcUzxdjecMoMGy', '1700667380avatar3.jpg', 0),
(24, 'Chepa', 'Candela', 'chepa', 'chepacandela@gmail.com', '$2y$10$awZnNZeHI5JYffMesbdIc.pulvDYNMmBXq3GywBaYMHpuE4IbpCGe', '1700753831Danor_2.png', 0),
(25, 'Alejandra', 'Díaz', 'alejandra1', 'alediaz@gmail.com', '$2y$10$.wWmd8nKQBVE4LXNMfxPDuqfQGseQZqoJ3xx0Ql7p94vDYH/s6L4W', '1700929764avatar10.jpg', 0),
(26, 'Chapulin', 'Colorado', 'chapulin', 'chapulincolorado@gmail.com', '$2y$10$8Q58XRsAkeV9wQOq/4jX6u1c1r8YWZo8w.p8lFQcxHE9O/.dGoFfa', '1700930368avatar8.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orden_id` (`orden_id`),
  ADD KEY `fk_producto_id` (`producto_id`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordenes_estatus` (`estatus_id`),
  ADD KEY `fk_user_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pagos_ordenes` (`orden_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`id_categoria`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_orden`
--
ALTER TABLE `detalle_orden`
  ADD CONSTRAINT `fk_orden_id` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`),
  ADD CONSTRAINT `fk_producto_id` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `fk_ordenes_estatus` FOREIGN KEY (`estatus_id`) REFERENCES `estatus` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_pagos_ordenes` FOREIGN KEY (`orden_id`) REFERENCES `ordenes` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
