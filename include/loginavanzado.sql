-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-04-2024 a las 21:40:06
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
-- Base de datos: `loginavanzado`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuarioId` int(11) NOT NULL,
  `usuarioNombreApellido` varchar(90) NOT NULL,
  `usuarioCorreo` varchar(50) NOT NULL,
  `usuarioPassword` varchar(200) NOT NULL,
  `usuarioFechaCreacion` datetime NOT NULL DEFAULT current_timestamp(),
  `usuarioFechaModificacion` datetime DEFAULT NULL,
  `usuarioFechaEliminacion` datetime DEFAULT NULL,
  `usuarioFechaActivacion` datetime DEFAULT NULL,
  `usuarioEstado` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuarioId`, `usuarioNombreApellido`, `usuarioCorreo`, `usuarioPassword`, `usuarioFechaCreacion`, `usuarioFechaModificacion`, `usuarioFechaEliminacion`, `usuarioFechaActivacion`, `usuarioEstado`) VALUES
(1, 'Test totrs', 'usert1@gmail.com', '12345678', '2024-03-06 15:36:33', NULL, NULL, '2024-03-06 15:36:33', 1),
(2, 'Administrador ', 'admin@gmail.com', 'B2B5fDvdl56uWg0B/UXYhRrb0fZphNvtWEE+sZHNHgI=', '2024-03-07 23:17:19', NULL, NULL, NULL, 1),
(10, 'Test totrs', 'romel_faustino@hotmail.com', 'Au919hSrMUi2v5nHyfiZzZ4bQwTJ6rU9WfRMjgJHyK0=', '2024-03-20 05:52:35', NULL, NULL, '2024-03-20 06:00:35', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuarioId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuarioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
