-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-02-2021 a las 20:33:11
-- Versión del servidor: 10.5.4-MariaDB
-- Versión de PHP: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `admin_nombre` varchar(45) NOT NULL,
  `admin_apellido` varchar(45) NOT NULL,
  `admin_usuario` varchar(50) NOT NULL,
  `admin_direccion` varchar(255) NOT NULL,
  `admin_telefono` varchar(25) NOT NULL,
  `admin_correo` varchar(45) DEFAULT NULL,
  `admin_pass` varchar(200) NOT NULL,
  `roles_rol_ID` tinyint(1) UNSIGNED NOT NULL,
  `sucursal_sucursal_ID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`admin_ID`),
  KEY `fk_admin_roles1_idx` (`roles_rol_ID`),
  KEY `fk_admin_sucursal1_idx` (`sucursal_sucursal_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_nombre`, `admin_apellido`, `admin_usuario`, `admin_direccion`, `admin_telefono`, `admin_correo`, `admin_pass`, `roles_rol_ID`, `sucursal_sucursal_ID`) VALUES
(1, 'Byron', 'Navarrete', 'BayNavCan', 'Somoto', '+505 8736-4374', 'navarretebay74@gmail.com', '$2y$10$MFnUkg8FHvdweL8VFuq8..as2CLKQH9HVnDNKVapUIlfv8.kiLcEe', 1, 1),
(2, 'Angel', 'Navarrete', 'AngNavCan', 'Somoto', '+505 8765-4321', 'idashlevel@gmail.com', '$2y$10$EDORcOWofk2Rbn024jcgROuPypIYc6BJKFAapq.ln5I3Frrt2CHza', 1, 1),
(3, 'Kevin', 'Jimenez', 'KevJimMen', 'Somoto', '+505 8767-5421', 'KevinJimenez@gmail.com', '$2y$10$KltfPwB.qQDV5FVEWnn14epIADSgoZ.RW821QZIfZu1.dmczmI8du', 2, 1),
(4, 'mitch', 'lovo', 'mitchlovo', 'ocotal', '+505 5856-9253', 'mitch@gmail.com', '$2y$10$HyCZJy.gaPfdM.H8d6dZ2eog5jm.RnN/jECoy7tFgHuDj4Mwkbj6u', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

DROP TABLE IF EXISTS `categorias_productos`;
CREATE TABLE IF NOT EXISTS `categorias_productos` (
  `cat_product_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de la categia del producto',
  `cat_product_nombre` varchar(45) NOT NULL COMMENT 'nombre de la categoria del producto',
  `cat_product_descripcion` varchar(45) NOT NULL COMMENT 'descripcion de la categoria del producto',
  PRIMARY KEY (`cat_product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`cat_product_ID`, `cat_product_nombre`, `cat_product_descripcion`) VALUES
(1, 'Madera', 'todo tipo de madera'),
(2, 'Metales', 'herramientas y otros'),
(3, 'Pintura', 'Todo en pintura de aceite y de agua'),
(5, 'Fontaneria', 'Todo en tuberias'),
(6, 'Otros', 'Otros'),
(10, 'Herramientas', 'todo tipo de herramientas'),
(11, 'Herreria', 'Todo en Herreria'),
(12, 'Fontaneria', 'Todo en tuberias'),
(13, 'Fontaneria', 'Todo en tuberias'),
(14, 'Pintura', 'Asesoria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_cedula` varchar(45) NOT NULL,
  `cliente_nombres` varchar(45) NOT NULL,
  `cliente_apellidos` varchar(45) NOT NULL,
  `cliente_username` varchar(45) NOT NULL,
  `cliente_telefono` varchar(20) DEFAULT NULL,
  `cliente_direccion` varchar(100) DEFAULT NULL,
  `cliente_correo` varchar(50) NOT NULL,
  `cliente_password` text NOT NULL,
  `fk_sucursal_cliente` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cliente_id`),
  KEY `fk_sucursal_cliente` (`fk_sucursal_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`cliente_id`, `cliente_cedula`, `cliente_nombres`, `cliente_apellidos`, `cliente_username`, `cliente_telefono`, `cliente_direccion`, `cliente_correo`, `cliente_password`, `fk_sucursal_cliente`) VALUES
(22, '321-030995-0001H', 'Byron', 'Navarrete', 'BayNavCan', '87364374', 'Somoto', 'navarretebay74@gmail.com', '$2y$10$4ZdyJcfP/kXDT6KgubUyHO6/ABOCUBfT/7afPLUWWlfYma3ehogVm', 1),
(23, '481-151198-1000B', 'mitch', 'lovo', 'mitchlovo', '5874165555', 'ocotal', 'mitch@gmail.com', '$2y$10$wUT80RHkyrtSh3IB.T4Jn.Q8Ot5dH9hxkzZGsBoWwAquLdBecW7WC', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `product_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID del producto',
  `product_nombre` varchar(60) NOT NULL COMMENT 'nombre del producto',
  `product_cantidad` int(11) NOT NULL DEFAULT 0 COMMENT 'cantidad en inventario',
  `product_precio` decimal(10,2) NOT NULL COMMENT 'precio unitario del producto',
  `product_descripcion` varchar(100) DEFAULT NULL COMMENT 'descripcion del producto',
  `product_foto` varchar(255) DEFAULT NULL,
  `product_marca` varchar(50) DEFAULT NULL,
  `categorias_productos_cat_product_ID` int(10) UNSIGNED NOT NULL,
  `unidad_medida_unidad_medida_id` int(11) NOT NULL,
  `proveedores_provee_ID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`product_ID`),
  KEY `fk_productos_categorias_productos_idx` (`categorias_productos_cat_product_ID`),
  KEY `fk_productos_unidad_medida1_idx` (`unidad_medida_unidad_medida_id`),
  KEY `fk_productos_proveedores1_idx` (`proveedores_provee_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`product_ID`, `product_nombre`, `product_cantidad`, `product_precio`, `product_descripcion`, `product_foto`, `product_marca`, `categorias_productos_cat_product_ID`, `unidad_medida_unidad_medida_id`, `proveedores_provee_ID`) VALUES
(1, 'Martillo', 100, '200.00', 'Martillo truper de acero', '823de_69.jpeg', '', 10, 1, 1),
(3, 'Martillo', 10, '100.00', 'martillo para ceramica', '8541._234.jpeg', '', 10, 1, 3),
(4, 'Cierra', 20, '500.00', 'Cierra para madera marca truper', '2111._631.jpeg', '', 6, 1, 1),
(5, 'Clavos de Acero', 100, '15.00', 'Clavos de Acero de 1 pulgada', '1063._492.jpeg', '', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proforma`
--

DROP TABLE IF EXISTS `proforma`;
CREATE TABLE IF NOT EXISTS `proforma` (
  `proforma_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `proforma_productos` text COLLATE utf8_spanish_ci NOT NULL,
  `proforma_estado` tinyint(1) NOT NULL DEFAULT 0,
  `cliente_cliente_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`proforma_ID`),
  KEY `fk_proforma_cliente_idx` (`cliente_cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proformatemporal`
--

DROP TABLE IF EXISTS `proformatemporal`;
CREATE TABLE IF NOT EXISTS `proformatemporal` (
  `proforma_id` int(11) NOT NULL AUTO_INCREMENT,
  `proforma_productos` text CHARACTER SET utf8mb4 NOT NULL,
  `cliente_cliente_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`proforma_id`),
  KEY `fk_proformaTemporal_cliente1_idx` (`cliente_cliente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `provee_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `provee_nombre` varchar(45) NOT NULL,
  `provee_direccion` varchar(255) NOT NULL,
  `provee_telefono` varchar(25) NOT NULL,
  `sucursal_sucursal_ID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`provee_ID`),
  KEY `fk_proveedores_sucursal1_idx` (`sucursal_sucursal_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`provee_ID`, `provee_nombre`, `provee_direccion`, `provee_telefono`, `sucursal_sucursal_ID`) VALUES
(1, 'LujoMax', 'Ocotal', '87675468', 1),
(3, 'FarmaCox', 'Ocotal', '87654214', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `rol_ID` tinyint(1) UNSIGNED NOT NULL COMMENT 'ID del rol',
  `rol_nombre` varchar(45) NOT NULL COMMENT 'nombre del rol',
  PRIMARY KEY (`rol_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_ID`, `rol_nombre`) VALUES
(1, 'admin'),
(2, 'registrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

DROP TABLE IF EXISTS `servicio`;
CREATE TABLE IF NOT EXISTS `servicio` (
  `ser_id` int(11) NOT NULL AUTO_INCREMENT,
  `ser_nombre` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_img` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  PRIMARY KEY (`ser_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ser_id`, `ser_nombre`, `ser_descripcion`, `ser_img`) VALUES
(3, 'Fontanería', 'Asesoría en instalación de tuberia', 'sin foto'),
(5, 'Entrega a domicilio', 'Se le hace la entrega del producto hasta su hogar', 'sin foto'),
(6, 'Carpintería', 'Asesoría', 'sin foto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_sucursal`
--

DROP TABLE IF EXISTS `servicio_sucursal`;
CREATE TABLE IF NOT EXISTS `servicio_sucursal` (
  `servicio_fk` int(11) NOT NULL,
  `sucursal_fk` int(10) UNSIGNED NOT NULL,
  KEY `servicio_fk` (`servicio_fk`),
  KEY `sucursal_fk` (`sucursal_fk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio_sucursal`
--

INSERT INTO `servicio_sucursal` (`servicio_fk`, `sucursal_fk`) VALUES
(3, 1),
(5, 2),
(6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

DROP TABLE IF EXISTS `sucursal`;
CREATE TABLE IF NOT EXISTS `sucursal` (
  `sucursal_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sucursal_nombre` varchar(100) NOT NULL,
  `sucursal_telefono` varchar(20) NOT NULL,
  `sucursal_correo` varchar(100) NOT NULL,
  `sucursal_direccion` varchar(255) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`sucursal_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`sucursal_ID`, `sucursal_nombre`, `sucursal_telefono`, `sucursal_correo`, `sucursal_direccion`, `activo`) VALUES
(1, 'Ferreteria San Luis', '87654321', 'SanLuis@gmail.com', 'Somoto, de enitel 1 C. al Norte', 1),
(2, 'Ferreteria Divino niño', '87654321', 'Divina@gmail.com', 'Ocotal', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

DROP TABLE IF EXISTS `unidad_medida`;
CREATE TABLE IF NOT EXISTS `unidad_medida` (
  `unidad_medida_id` int(11) NOT NULL AUTO_INCREMENT,
  `unidad_medida_tipo` varchar(45) NOT NULL,
  `unidad_medida_nombre` varchar(45) NOT NULL,
  `unidad_medida_abreviatura` varchar(10) NOT NULL,
  PRIMARY KEY (`unidad_medida_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`unidad_medida_id`, `unidad_medida_tipo`, `unidad_medida_nombre`, `unidad_medida_abreviatura`) VALUES
(1, 'Unidad', 'Unidad', 'und'),
(2, 'Metros', 'Metros', 'mts');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `roles_rol_ID` FOREIGN KEY (`roles_rol_ID`) REFERENCES `roles` (`rol_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sucursal_sucursal_ID` FOREIGN KEY (`sucursal_sucursal_ID`) REFERENCES `sucursal` (`sucursal_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_sucursal_cliente` FOREIGN KEY (`fk_sucursal_cliente`) REFERENCES `sucursal` (`sucursal_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias_productos` FOREIGN KEY (`categorias_productos_cat_product_ID`) REFERENCES `categorias_productos` (`cat_product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_proveedores1` FOREIGN KEY (`proveedores_provee_ID`) REFERENCES `proveedores` (`provee_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_unidad_medida1` FOREIGN KEY (`unidad_medida_unidad_medida_id`) REFERENCES `unidad_medida` (`unidad_medida_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proforma`
--
ALTER TABLE `proforma`
  ADD CONSTRAINT `fk_proforma_cliente` FOREIGN KEY (`cliente_cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proformatemporal`
--
ALTER TABLE `proformatemporal`
  ADD CONSTRAINT `fk_proformaTemporal_cliente1` FOREIGN KEY (`cliente_cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_sucursal1` FOREIGN KEY (`sucursal_sucursal_ID`) REFERENCES `sucursal` (`sucursal_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `servicio_sucursal`
--
ALTER TABLE `servicio_sucursal`
  ADD CONSTRAINT `servicio_fk` FOREIGN KEY (`servicio_fk`) REFERENCES `servicio` (`ser_id`),
  ADD CONSTRAINT `sucursal_fk` FOREIGN KEY (`sucursal_fk`) REFERENCES `sucursal` (`sucursal_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
