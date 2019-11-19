-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2015 a las 23:04:13
-- Versión del servidor: 5.5.32
-- Versión de PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `json`
--
CREATE DATABASE IF NOT EXISTS `json` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `json`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activaciones`
--

CREATE TABLE IF NOT EXISTS `activaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `codigo_activacion` text NOT NULL,
  `fecha_generacion` varchar(20) NOT NULL,
  `fecha_activacion` varchar(20) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `activaciones`
--

INSERT INTO `activaciones` (`id`, `id_cliente`, `codigo_activacion`, `fecha_generacion`, `fecha_activacion`, `estatus`) VALUES
(1, 1, 'iuXDJHbOLHay', '2015-04-6 15:57:28', '2015-04-6 15:58:06', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `edad` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL DEFAULT 'sinpass',
  `estatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `sexo`, `edad`, `email`, `Password`, `estatus`) VALUES
(1, 'manuel', 'cortes crisanto', 'Masculino', 25, 'crisant_89@hotmail.com', 'KKBhsglig0aLTSzEC008lPQI4/C6VQoE5ckjiMDGjHk=', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
