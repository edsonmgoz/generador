-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2015 a las 19:08:54
-- Versión del servidor: 5.6.20
-- Versión de PHP: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `generador`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`category_name`) VALUES
('Repuestos'),
('Herramientas'),
('Gomeria'),
('Aceites'),
('Sopladores'),
('Ventiladores'),
('Metales'),
('Platicos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `product_price` float(6,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_name`, `product_price`) VALUES
('Monitor', 10.00),
('Teclado inalambrico', 25.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id_user` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf32 COLLATE utf32_spanish_ci NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `full_name`, `email`) VALUES
(1, 'edsonsm', 'Edson Mollericona Marin', 'edsonsm@hotmail.com'),
(2, 'danu_daniel', 'Dany Daniel Morales Machicado', 'danu_daniel@hotmail.com'),
(3, 'sherk_182', 'Henry Perez Gumiel', 'sherk_182@hotmail.com'),
(4, 'maudegh', 'Mauricio Montaño Orellana', 'maudeg@hotmail.com'),
(5, 'pancho', 'Francisco Lozada Gomez', 'pancho@yahoo.com'),
(6, 'matias', 'Matias Heredia Mendoza', 'matias@gmail.com'),
(7, 'jugoso', 'Elfer Sergio Martinez', 'jugoso@hotmail.com'),
(8, 'bolachiu', 'Carlos Morales Machicado', 'bolachiu@yahoo.com'),
(9, 'lolita', 'Lolita Gonzales Martinez', 'lolita@gmail.com'),
(10, 'rosita', 'Rosita Gomez Marsell', 'rosita@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
