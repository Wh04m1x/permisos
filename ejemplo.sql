-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 04-12-2014 a las 21:23:36
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `ejemplo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigna_permisos_perfiles`
--

CREATE TABLE IF NOT EXISTS `asigna_permisos_perfiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PERFIL` int(11) NOT NULL,
  `ID_ICONO` int(11) NOT NULL,
  `ID_MENU` int(11) NOT NULL,
  `ESTATUS` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `asigna_permisos_perfiles`
--

INSERT INTO `asigna_permisos_perfiles` (`ID`, `ID_PERFIL`, `ID_ICONO`, `ID_MENU`, `ESTATUS`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 3, 1, 0),
(3, 1, 2, 2, 1),
(4, 1, 2, 1, 1),
(5, 1, 1, 2, 1),
(6, 1, 1, 3, 1),
(7, 1, 2, 3, 1),
(8, 1, 1, 4, 1),
(9, 1, 2, 4, 1),
(10, 1, 1, 5, 1),
(11, 1, 2, 5, 0),
(12, 1, 3, 5, 1),
(13, 2, 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iconos`
--

CREATE TABLE IF NOT EXISTS `iconos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) NOT NULL,
  `IMAGEN` varchar(100) NOT NULL DEFAULT 'assets/img/usuarios.png',
  `ESTATUS` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `iconos`
--

INSERT INTO `iconos` (`ID`, `DESCRIPCION`, `IMAGEN`, `ESTATUS`) VALUES
(1, 'Editar', 'assets/img/editar.png', 1),
(2, 'Eliminar', 'assets/img/eliminar.png', 1),
(3, 'Asignar Permisos a Perfiles', 'assets/img/icon_permisos.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(50) NOT NULL,
  `IMAGEN` varchar(50) NOT NULL DEFAULT 'assets/img/not_found.png',
  `URL` varchar(50) DEFAULT NULL,
  `ORDENAMIENTO` int(11) NOT NULL DEFAULT '0',
  `ESTATUS` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`ID`, `DESCRIPCION`, `IMAGEN`, `URL`, `ORDENAMIENTO`, `ESTATUS`) VALUES
(0, 'Nodo Raiz', 'assets/img/not_found.png', '#', 0, 1),
(1, 'Usuarios', 'assets/img/Usuarios.png', 'usuarios.php', 1, 1),
(2, 'Menu del Sistema', 'assets/img/menu.png', 'menu.php', 2, 1),
(3, 'Mis Datos', 'assets/img/configuracion.png', 'MisDatos.php', 3, 3),
(4, 'Iconos', 'assets/img/iconos.png', 'iconos.php', 4, 1),
(5, 'Perfiles', 'assets/img/Perfiles.png', 'perfiles.php', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE IF NOT EXISTS `perfiles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DESCRIPCION` varchar(30) NOT NULL,
  `ESTATUS` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`ID`, `DESCRIPCION`, `ESTATUS`) VALUES
(1, 'Administrador', 1),
(2, 'Invitado', 1),
(3, 'Prueba', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_MENU` int(11) NOT NULL,
  `ESTATUS` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`ID`, `ID_USUARIO`, `ID_MENU`, `ESTATUS`) VALUES
(1, 1, 1, 1),
(5, 1, 5, 1),
(7, 2, 3, 1),
(9, 1, 2, 1),
(13, 1, 3, 1),
(15, 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_iconos`
--

CREATE TABLE IF NOT EXISTS `permisos_iconos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_USUARIO` int(11) NOT NULL,
  `ID_ICONO` int(11) NOT NULL,
  `ID_MENU` int(11) NOT NULL,
  `ESTATUS` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198 ;

--
-- Volcado de datos para la tabla `permisos_iconos`
--

INSERT INTO `permisos_iconos` (`ID`, `ID_USUARIO`, `ID_ICONO`, `ID_MENU`, `ESTATUS`) VALUES
(41, 1, 1, 0, 1),
(42, 1, 2, 0, 1),
(87, 2, 1, 3, 1),
(188, 1, 1, 1, 1),
(189, 1, 2, 2, 1),
(190, 1, 2, 1, 1),
(191, 1, 1, 2, 1),
(192, 1, 1, 3, 1),
(193, 1, 2, 3, 1),
(194, 1, 1, 4, 1),
(195, 1, 2, 4, 1),
(196, 1, 1, 5, 1),
(197, 1, 3, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(100) NOT NULL,
  `APELLIDOS` varchar(100) NOT NULL,
  `CORREO` varchar(50) NOT NULL,
  `USUARIO` varchar(20) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `FECHA_REGISTRO` varchar(20) NOT NULL,
  `FECHA_ACTIVACION` varchar(20) NOT NULL,
  `FECHA_ACTUALIZACION` varchar(20) NOT NULL,
  `VERIFICADO` int(11) NOT NULL DEFAULT '0',
  `ESTATUS` int(11) NOT NULL DEFAULT '0',
  `ACCESO` int(11) NOT NULL DEFAULT '0',
  `TIPO_USUARIO` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `NOMBRE`, `APELLIDOS`, `CORREO`, `USUARIO`, `PASSWORD`, `FECHA_REGISTRO`, `FECHA_ACTIVACION`, `FECHA_ACTUALIZACION`, `VERIFICADO`, `ESTATUS`, `ACCESO`, `TIPO_USUARIO`) VALUES
(1, 'Desarrollo', 'en PHP', 'crisant_89@hotmail.com', 'php', '123', '', '', '2014-12-4 13:55:33', 1, 1, 0, 1),
(2, 'Manuel', 'Cortes Crisanto', 'crisant_899@hotmail.com', 'crisant_899', '2qleDBkrWA9G', '2014-12-3 13:04:45', '', '2014-12-4 13:05:00', 1, 1, 0, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
