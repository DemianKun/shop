-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-04-2026 a las 19:17:19
-- Versión del servidor: 11.8.6-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u975895695_delevery`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comercio`
--

CREATE TABLE `comercio` (
  `id_comercio` int(11) NOT NULL,
  `nombre_responsable` varchar(30) DEFAULT NULL,
  `tipo_comercio` varchar(15) DEFAULT NULL,
  `horario_apertura` time DEFAULT NULL,
  `horario_cierre` time DEFAULT NULL,
  `dias_operacion` varchar(15) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_direccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `comercio`
--

INSERT INTO `comercio` (`id_comercio`, `nombre_responsable`, `tipo_comercio`, `horario_apertura`, `horario_cierre`, `dias_operacion`, `id_usuario`, `id_direccion`) VALUES
(1, 'Eduardo Lopez', 'Supermercado', '09:00:00', '12:00:00', NULL, 7, 1),
(2, 'Francisco', 'Restaurante', '12:34:00', '12:34:00', NULL, 7, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `mensaje` text NOT NULL,
  `tipo` varchar(50) NOT NULL DEFAULT 'general',
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `id_envio` int(11) DEFAULT NULL,
  `id_comercio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `contactos`
--

INSERT INTO `contactos` (`id`, `nombre`, `email`, `telefono`, `mensaje`, `tipo`, `fecha_creacion`, `id_usuario`, `id_envio`, `id_comercio`) VALUES
(5, 'Armando', 'EstebQuito@gmail.com', '5518253545', 'd', 'cotizar_envio', '2025-12-04 20:23:15', NULL, NULL, NULL),
(6, 'Armando', 'EstebQuito@gmail.com', '5518253545', 'd', 'cotizar_envio', '2025-12-04 20:24:35', NULL, NULL, NULL),
(7, 'e32', 'EstebQuito@gmail.com', '5518253545', 're', 'cotizar_envio', '2026-01-14 20:54:54', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `origen` varchar(255) NOT NULL,
  `destino` varchar(255) NOT NULL,
  `peso` decimal(10,2) DEFAULT NULL,
  `dimensiones` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `id_comercio` int(11) DEFAULT NULL,
  `id_origen_direccion` int(11) DEFAULT NULL,
  `id_destino` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destino`
--

CREATE TABLE `destino` (
  `id_destino` int(11) NOT NULL,
  `codigo_postal` varchar(15) DEFAULT NULL,
  `calle` varchar(30) DEFAULT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `manzana` varchar(10) DEFAULT NULL,
  `lote` varchar(10) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `instrucciones` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `codigo_postal` varchar(15) DEFAULT NULL,
  `calle` varchar(30) NOT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `manzana` varchar(10) DEFAULT NULL,
  `lote` varchar(10) DEFAULT NULL,
  `colonia` varchar(50) DEFAULT NULL,
  `municipio` varchar(30) DEFAULT NULL,
  `estado` varchar(30) DEFAULT NULL,
  `referencias` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `codigo_postal`, `calle`, `numero`, `manzana`, `lote`, `colonia`, `municipio`, `estado`, `referencias`) VALUES
(1, '56567', 'AV 12 DE DICIEMBRE', '4', '30', '09', 'wenceslao victoria zoto', 'Ixtapaluca', 'México', NULL),
(2, '56619', 'Recursos hidraulicos', 'Lt 11', '12', '12', 'Dario martinez', '124', '41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id` int(11) NOT NULL,
  `calle` varchar(100) DEFAULT NULL,
  `num_ext` varchar(10) DEFAULT NULL,
  `num_int` varchar(10) DEFAULT NULL,
  `colonia` varchar(100) DEFAULT NULL,
  `cp` varchar(10) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `referencias` text DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id`, `calle`, `num_ext`, `num_int`, `colonia`, `cp`, `ciudad`, `referencias`, `fecha`) VALUES
(1, 'Bella Vista ', '34', '', 'Pueblo Nuevo ', '56580', 'México ', 'Escuela Primaria Cuauhtémoc ', '2025-12-29 17:03:01'),
(2, '', '', '', '', '', '', '', '2025-12-29 17:03:18'),
(3, '', '', '', '', '', '', '', '2025-12-29 18:52:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

CREATE TABLE `envios` (
  `id_envio` int(11) NOT NULL,
  `empresa` varchar(30) DEFAULT NULL,
  `valor` decimal(10,0) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `n_referencia` varchar(50) DEFAULT NULL,
  `horario_recoger` varchar(20) DEFAULT NULL,
  `tipo_paquete` varchar(30) DEFAULT NULL,
  `id_direccion` int(11) DEFAULT NULL,
  `id_destino` int(11) DEFAULT NULL,
  `id_comercio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_envio`
--

CREATE TABLE `estado_envio` (
  `id_estado` int(11) NOT NULL,
  `id_envio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `nuevo_estado` varchar(30) DEFAULT NULL,
  `observaciones` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `fecha` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificacion`
--

CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL,
  `id_envio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL,
  `mensaje` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_fotos`
--

CREATE TABLE `registros_fotos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre_archivo` varchar(100) NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidor`
--

CREATE TABLE `repartidor` (
  `id_repartidor` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_envio` int(11) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `id_vehiculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repartidor`
--

INSERT INTO `repartidor` (`id_repartidor`, `id_usuario`, `id_envio`, `fecha_nac`, `id_vehiculo`) VALUES
(1, 5, NULL, NULL, 1),
(2, 8, NULL, NULL, 2),
(3, 11, NULL, NULL, 6),
(4, 13, NULL, NULL, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL,
  `id_envio` int(11) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `total_envios` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `tipo_rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `tipo_rol`) VALUES
(1, 'Administrador'),
(2, 'Comercio'),
(3, 'Repartidor'),
(4, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_recuperacion`
--

CREATE TABLE `tokens_recuperacion` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expiracion` datetime NOT NULL,
  `usado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(30) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `id_rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `correo`, `contrasena`, `fecha_registro`, `id_rol`) VALUES
(1, 'Prueba', 'ejemplo@gmail.com', '$2y$10$vyCrHQisH2CPqUxr3RsR7udSQGljHJfLgvhJUw61MVl3DAFa6uxAO', '2026-03-02 20:26:59', 3),
(2, 'BDO', 'admin@gmail.com', '$2y$10$Ob5KbmhIhusbiG/woWuIme3jW/FZiho1rUyAcZPJ7JKW/HpZ2ssky', '2026-03-02 20:28:46', 2),
(3, 'Esme', 'esme@gmail.com', '$2y$10$VsdxsGjVds942y5rPvGmeOX3SmGwYPux6R7XqxzOQ0ni1CPH3S5ae', '2026-03-02 20:29:32', 2),
(4, 'Admin', 'delivery@gmail.com', '$2y$10$EiGOPL1O6awmW9kEEPEIW.Cj7z0BRGQdHGNfYx/EVcuq64gcMNRPy', '2026-03-03 04:44:41', 1),
(5, 'Lele digital', 'lopez2000ms05d17@gmail.com', '$2y$10$dV1iGNhRAhDEeHUkVY6EMu4xj2BDgjzWwu8QZzh8kEywpwz3hoCXO', '2026-03-03 19:34:33', 2),
(7, 'Arturo Pérez Ordoñez', 'test@mftoy.com', '$2y$10$sNZ9MXCnaIPWlhjA0Js4aO6SdfMHyBWF2RNXC7INownT/Brd0O4km', '2026-03-10 21:54:54', 2),
(9, 'Arturo', 'arpeoz125@gmail.com', '$2y$10$x5X0uwi97wfjITlNKJ74r.WYENRKb/h1X7v4CAWNd2mM90nxpRTei', '2026-03-10 21:58:03', 2),
(11, 'Arturo Pérez Ordoñez', 'operativo2@mftoy.com', '$2y$10$ZM2ysr8Mln4JEzvWic.0NucsLf5.27cpK53W6SS6bcaYoUc7wf/jC', '2026-03-10 22:00:19', 3),
(13, 'Arturo Pérez Ordoñez', 'operativo12@mftoy.com', '$2y$10$ekarkQ2PD65Vl/E1pbpzIewQYd3VcrhKGi.j4RDvTHKsgHkkdBFC6', '2026-04-22 19:06:05', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `id_vehiculo` int(11) NOT NULL,
  `tipo_vehiculo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `matricula` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`id_vehiculo`, `tipo_vehiculo`, `marca`, `modelo`, `color`, `matricula`) VALUES
(1, 'Moto', 'OTROS', 'Mortalika', 'azul', 'nuevoadmin'),
(2, 'Moto', 'italica', '2008', 'roja', 'MF456'),
(6, 'Carro', 'gyvgvh', 'Mortalika', 'azul', 'hhvgvgvuh'),
(8, 'Moto', '12345678999999', 'Mortalika', 'azul', '12345678901');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comercio`
--
ALTER TABLE `comercio`
  ADD PRIMARY KEY (`id_comercio`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_direccion` (`id_direccion`);

--
-- Indices de la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contactos_id_usuario` (`id_usuario`),
  ADD KEY `idx_contactos_id_envio` (`id_envio`),
  ADD KEY `idx_contactos_id_comercio` (`id_comercio`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cotz_id_usuario` (`id_usuario`),
  ADD KEY `idx_cotz_id_comercio` (`id_comercio`),
  ADD KEY `idx_cotz_id_origen` (`id_origen_direccion`),
  ADD KEY `idx_cotz_id_destino` (`id_destino`);

--
-- Indices de la tabla `destino`
--
ALTER TABLE `destino`
  ADD PRIMARY KEY (`id_destino`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `envios`
--
ALTER TABLE `envios`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `id_direccion` (`id_direccion`),
  ADD KEY `id_destino` (`id_destino`),
  ADD KEY `id_comercio` (`id_comercio`);

--
-- Indices de la tabla `estado_envio`
--
ALTER TABLE `estado_envio`
  ADD PRIMARY KEY (`id_estado`),
  ADD KEY `id_envio` (`id_envio`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_envio` (`id_envio`);

--
-- Indices de la tabla `registros_fotos`
--
ALTER TABLE `registros_fotos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `repartidor`
--
ALTER TABLE `repartidor`
  ADD PRIMARY KEY (`id_repartidor`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_vehiculo` (`id_vehiculo`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `id_envio` (`id_envio`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `idx_token` (`token`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`id_vehiculo`),
  ADD UNIQUE KEY `matricula` (`matricula`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comercio`
--
ALTER TABLE `comercio`
  MODIFY `id_comercio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contactos`
--
ALTER TABLE `contactos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destino`
--
ALTER TABLE `destino`
  MODIFY `id_destino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `envios`
--
ALTER TABLE `envios`
  MODIFY `id_envio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_envio`
--
ALTER TABLE `estado_envio`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificacion`
--
ALTER TABLE `notificacion`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registros_fotos`
--
ALTER TABLE `registros_fotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `repartidor`
--
ALTER TABLE `repartidor`
  MODIFY `id_repartidor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  MODIFY `id_vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comercio`
--
ALTER TABLE `comercio`
  ADD CONSTRAINT `comercio_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comercio_ibfk_2` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `contactos`
--
ALTER TABLE `contactos`
  ADD CONSTRAINT `fk_contactos_comercio` FOREIGN KEY (`id_comercio`) REFERENCES `comercio` (`id_comercio`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contactos_envio` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id_envio`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contactos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `fk_cotz_comercio` FOREIGN KEY (`id_comercio`) REFERENCES `comercio` (`id_comercio`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cotz_destino_dest` FOREIGN KEY (`id_destino`) REFERENCES `destino` (`id_destino`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cotz_origen_dir` FOREIGN KEY (`id_origen_direccion`) REFERENCES `direccion` (`id_direccion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_cotz_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `envios_ibfk_1` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`),
  ADD CONSTRAINT `envios_ibfk_2` FOREIGN KEY (`id_destino`) REFERENCES `destino` (`id_destino`),
  ADD CONSTRAINT `envios_ibfk_3` FOREIGN KEY (`id_comercio`) REFERENCES `comercio` (`id_comercio`);

--
-- Filtros para la tabla `estado_envio`
--
ALTER TABLE `estado_envio`
  ADD CONSTRAINT `estado_envio_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id_envio`);

--
-- Filtros para la tabla `notificacion`
--
ALTER TABLE `notificacion`
  ADD CONSTRAINT `notificacion_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id_envio`);

--
-- Filtros para la tabla `repartidor`
--
ALTER TABLE `repartidor`
  ADD CONSTRAINT `repartidor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `repartidor_ibfk_2` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id_envio`),
  ADD CONSTRAINT `repartidor_ibfk_3` FOREIGN KEY (`id_vehiculo`) REFERENCES `vehiculo` (`id_vehiculo`);

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `reportes_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envios` (`id_envio`);

--
-- Filtros para la tabla `tokens_recuperacion`
--
ALTER TABLE `tokens_recuperacion`
  ADD CONSTRAINT `tokens_recuperacion_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
