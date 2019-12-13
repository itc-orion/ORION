-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-09-2019 a las 06:42:52
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `orion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `inicio_suspencion` time DEFAULT NULL,
  `fin_suspencion` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `inicio_suspencion`, `fin_suspencion`) VALUES
(1, '12:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rangos`
--

CREATE TABLE `rangos` (
  `id` int(11) NOT NULL,
  `longitud` decimal(15,10) DEFAULT NULL,
  `latitud` decimal(15,10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rangos`
--

INSERT INTO `rangos` (`id`, `longitud`, `latitud`) VALUES
(1, '987.0000000000', '123.0000000000'),
(2, '986.0000000000', '124.0000000000'),
(3, '976.0000000000', '134.0000000000'),
(4, '978.0000000000', '132.0000000000'),
(5, '9786.0000000000', '1243.0000000000'),
(6, '9678.0000000000', '1432.0000000000'),
(7, '9576.0000000000', '1623.0000000000'),
(8, '9172.0000000000', '1824.0000000000'),
(9, '9183.0000000000', '1825.0000000000'),
(10, '9158.0000000000', '1826.0000000000'),
(11, '18472.0000000000', '1829.0000000000'),
(12, '1749.0000000000', '8126.0000000000'),
(13, '6712.0000000000', '3251.0000000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `semaforos`
--

CREATE TABLE `semaforos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tiempo_inicio` int(11) DEFAULT NULL,
  `id_horario` int(11) DEFAULT NULL,
  `id_rango` int(11) DEFAULT NULL,
  `id_tverde` int(11) DEFAULT NULL,
  `id_tamarillo` int(11) DEFAULT NULL,
  `id_trojo` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `semaforos`
--

INSERT INTO `semaforos` (`id`, `nombre`, `status`, `tiempo_inicio`, `id_horario`, `id_rango`, `id_tverde`, `id_tamarillo`, `id_trojo`, `fecha_creacion`) VALUES
(1, 'MEGA1', 1, 0, 1, 1, 1, 1, 1, '2019-09-10 15:43:24'),
(2, 'MEGA2', 1, 0, 1, 2, 1, 1, 1, '2019-09-10 15:44:23'),
(3, 'ELEKTRA1', 1, 0, 1, 3, 2, 1, 2, '2019-09-10 15:45:21'),
(4, 'ELEKTRA2', 1, 0, 1, 4, 3, 1, 3, '2019-09-10 15:46:16'),
(5, 'COPPEL1', 1, 0, 1, 5, 1, 1, 1, '2019-09-10 15:48:19'),
(6, 'COPPEL2', 1, 0, 1, 6, 3, 1, 3, '2019-09-10 15:50:41'),
(7, 'BOMBEROS1', 1, 0, 1, 7, 1, 1, 1, '2019-09-10 15:54:59'),
(8, 'BOMBEROS2', 1, 0, 1, 8, 4, 1, 4, '2019-09-10 15:55:53'),
(9, 'CHEVROLET1', 1, 0, 1, 9, 3, 1, 3, '2019-09-10 15:56:44'),
(10, 'CHEVROLET2', 1, 0, 1, 10, 3, 1, 3, '2019-09-10 15:57:36'),
(11, 'Edificio F dela', 1, 0, 1, 11, 5, 2, 4, '2019-09-10 15:59:01'),
(12, 'Edificio F tras', 1, 0, 1, 12, 1, 1, 1, '2019-09-10 16:00:29'),
(13, 'Pasillo edifici', 1, 0, 1, 13, 6, 1, 5, '2019-09-10 16:04:06');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `semaforos_all`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `semaforos_all` (
`id` int(11)
,`nombre` varchar(15)
,`status` tinyint(1)
,`longitud` decimal(15,10)
,`latitud` decimal(15,10)
,`tiempo_inicio` int(11)
,`inicio_suspencion` time
,`fin_suspencion` time
,`tiempo_verde` int(11)
,`tiempo_amarillo` int(11)
,`tiempo_rojo` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_amarillo`
--

CREATE TABLE `tiempos_amarillo` (
  `id` int(11) NOT NULL,
  `tiempo_amarillo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiempos_amarillo`
--

INSERT INTO `tiempos_amarillo` (`id`, `tiempo_amarillo`) VALUES
(1, 3),
(2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_rojo`
--

CREATE TABLE `tiempos_rojo` (
  `id` int(11) NOT NULL,
  `tiempo_rojo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiempos_rojo`
--

INSERT INTO `tiempos_rojo` (`id`, `tiempo_rojo`) VALUES
(1, 13),
(2, 15),
(3, 16),
(4, 14),
(5, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_verde`
--

CREATE TABLE `tiempos_verde` (
  `id` int(11) NOT NULL,
  `tiempo_verde` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tiempos_verde`
--

INSERT INTO `tiempos_verde` (`id`, `tiempo_verde`) VALUES
(1, 13),
(2, 15),
(3, 16),
(4, 14),
(5, 17),
(6, 12);

-- --------------------------------------------------------

--
-- Estructura para la vista `semaforos_all`
--
DROP TABLE IF EXISTS `semaforos_all`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `semaforos_all`  AS  select `s`.`id` AS `id`,`s`.`nombre` AS `nombre`,`s`.`status` AS `status`,`r`.`longitud` AS `longitud`,`r`.`latitud` AS `latitud`,`s`.`tiempo_inicio` AS `tiempo_inicio`,`h`.`inicio_suspencion` AS `inicio_suspencion`,`h`.`fin_suspencion` AS `fin_suspencion`,`tv`.`tiempo_verde` AS `tiempo_verde`,`ta`.`tiempo_amarillo` AS `tiempo_amarillo`,`tr`.`tiempo_rojo` AS `tiempo_rojo` from (((((`semaforos` `s` join `horarios` `h`) join `rangos` `r`) join `tiempos_verde` `tv`) join `tiempos_amarillo` `ta`) join `tiempos_rojo` `tr`) where `h`.`id` = `s`.`id_horario` and `r`.`id` = `s`.`id_rango` and `tv`.`id` = `s`.`id_tverde` and `ta`.`id` = `s`.`id_tamarillo` and `tr`.`id` = `s`.`id_trojo` order by `s`.`id` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rangos`
--
ALTER TABLE `rangos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `semaforos`
--
ALTER TABLE `semaforos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_horario` (`id_horario`),
  ADD KEY `id_rango` (`id_rango`),
  ADD KEY `id_tverde` (`id_tverde`),
  ADD KEY `id_tamarillo` (`id_tamarillo`),
  ADD KEY `id_trojo` (`id_trojo`);

--
-- Indices de la tabla `tiempos_amarillo`
--
ALTER TABLE `tiempos_amarillo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiempos_rojo`
--
ALTER TABLE `tiempos_rojo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tiempos_verde`
--
ALTER TABLE `tiempos_verde`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rangos`
--
ALTER TABLE `rangos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `semaforos`
--
ALTER TABLE `semaforos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tiempos_amarillo`
--
ALTER TABLE `tiempos_amarillo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tiempos_rojo`
--
ALTER TABLE `tiempos_rojo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tiempos_verde`
--
ALTER TABLE `tiempos_verde`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `semaforos`
--
ALTER TABLE `semaforos`
  ADD CONSTRAINT `semaforos_ibfk_1` FOREIGN KEY (`id_horario`) REFERENCES `horarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semaforos_ibfk_2` FOREIGN KEY (`id_rango`) REFERENCES `rangos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semaforos_ibfk_3` FOREIGN KEY (`id_tverde`) REFERENCES `tiempos_verde` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semaforos_ibfk_4` FOREIGN KEY (`id_tamarillo`) REFERENCES `tiempos_amarillo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `semaforos_ibfk_5` FOREIGN KEY (`id_trojo`) REFERENCES `tiempos_rojo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
