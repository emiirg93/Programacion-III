-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-07-2019 a las 09:48:43
-- Versión del servidor: 10.3.16-MariaDB
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `practicasp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `idCompra` int(11) NOT NULL,
  `idComprador` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` varchar(25) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`idCompra`, `idComprador`, `nombre`, `fecha`, `precio`) VALUES
(1, 1, 'Pepsi', '09-07-2019', '50'),
(2, 3, 'pitusas', '15-07-2019', '30'),
(3, 1, 'Redmi Note 7', '16-07-2019', '12.500'),
(4, 2, 'Redoxone', '16-07-2019', '250'),
(5, 2, 'Levite', '16-07-2019', '60'),
(6, 1, 'coca-cola', '16-07-2019', '60');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `usuario` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `metodo` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `ruta` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `hora` varchar(10) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`usuario`, `metodo`, `ruta`, `hora`) VALUES
('admin', 'POST', '/PSP/public/login', '8:57 am'),
('admin', 'POST', '/PSP/public/login', '9:02 am'),
('admin', 'POST', '/PSP/public/login', ''),
('admin', 'POST', '/PSP/public/login', ''),
('admin', 'POST', '/PSP/public/login', '4:08 am'),
('admin', 'POST', '/PSP/public/login', '4:29 am'),
('admin', 'POST', '/PSP/public/compra', '4:36 am'),
('admin', 'POST', '/PSP/public/compra', '4:37 am'),
('admin', 'POST', '/PSP/public/compra', '4:38 am'),
('admin', 'POST', '/PSP/public/compra', '4:38 am'),
('admin', 'POST', '/PSP/public/compra', '4:41 am'),
('admin', 'POST', '/PSP/public/compra', '4:43 am'),
('admin', 'POST', '/PSP/public/compra', '4:44 am'),
('emiliano', 'POST', '/PSP/public/login', '4:47 am');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `clave` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `sexo` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `perfil` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `clave`, `sexo`, `perfil`) VALUES
(1, 'admin', 'admin', 'femenino', 'admin'),
(2, 'emiliano', '1234', 'masculino', 'usuario'),
(3, 'Roberto', '555', 'masculino', 'usuario'),
(6, 'leo', 'aasdasda', 'hombre', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`idCompra`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
