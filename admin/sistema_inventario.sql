-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 05-02-2021 a las 17:45:06
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
  PRIMARY KEY (`admin_ID`,`roles_rol_ID`),
  KEY `fk_admin_roles1_idx` (`roles_rol_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_nombre`, `admin_apellido`, `admin_usuario`, `admin_direccion`, `admin_telefono`, `admin_correo`, `admin_pass`, `roles_rol_ID`) VALUES
(3, 'Byron', 'Navarrete', 'BayNavCan', 'Somoto', '+505 8736-4374', 'navarretebay74@gmail.com', '$2y$10$PYLUIk1VqgcKL1bf7dPs7OB4xnsjWjsmBQ4dyQ0aTCcN0IHyi7aWa', 1),
(4, 'Angel', 'Navarrete', 'AngNavCan', 'Somoto', '+505 8765-4321', 'idashlevel@gmail.com', '$2y$10$L7dkiT2RY3dwGsQFL6S.U.hvp8UC3GowpImheaVIKJY3vo0HLHPd.', 2),
(5, 'Kevin', 'Jimenez', 'KevJim', 'Somoto', '+505 8767-6543', 'KevJem@gmail.com', '$2y$10$UxLmNU6O/hC3YJZVLa6BlOAJjyynPHhXrLuM7c6oNfYTGeDfM5H/C', 2),
(6, 'Jose', 'Gomez', 'Jos2020', 'Managua', '+505 8765-4321', 'gomezjose@gmail.com', '$2y$10$FHcqwbk2sY00N8eWFzZw/eHjFlcraewt3XpeakFBXfMDIxOtUeG02', 2),
(8, 'Mario', 'Gomez', 'MarioG', 'Somoto', '+505 1223-3445', 'MarioG@gmail.com', '$2y$10$9jj17o0gG6Y1BafUyPjSNeRrIsdPApTtSGOH.s1/NK/9V/bNDSRO6', 2),
(9, 'Karol', 'Jimenez', 'KarJim', 'Somoto', '+505 8674-5321', 'KarJim@gmail.com', '$2y$10$iT2CDDvtA6JI60AUc7mzYeBuwSSqkHsxmJ3uBnt52kLNpBf5oJ9UC', 2),
(11, 'Sara', 'Lopez', 'SarLop', 'Somoto', '+505 1223-1234', 'SarLop@gmail.com', '$2y$10$ddMVD3An9wbx4rhwi37tjer7VImlP/gtIARJTDyUjKXj1uKD5mCWS', 2),
(12, 'Carlos', 'Rodriguez', 'CarRod', 'Somoto', '+505 8967-6854', 'CarRod@gmail.com', '$2y$10$yDZAthzvyNHuNRsGCd2VP.jKFD3T.8HhT2LT25fh1gIzJex0gqY9C', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_sucursal`
--

DROP TABLE IF EXISTS `admin_sucursal`;
CREATE TABLE IF NOT EXISTS `admin_sucursal` (
  `fk_sucursal` int(10) UNSIGNED NOT NULL,
  `fk_admin` int(11) NOT NULL,
  KEY `fk_sucursal` (`fk_sucursal`),
  KEY `fk_admin` (`fk_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `admin_sucursal`
--

INSERT INTO `admin_sucursal` (`fk_sucursal`, `fk_admin`) VALUES
(1, 3),
(1, 4),
(2, 5),
(2, 6),
(2, 8),
(1, 9),
(2, 11),
(2, 12);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`cat_product_ID`, `cat_product_nombre`, `cat_product_descripcion`) VALUES
(1, 'Madera', 'todo tipo de madera'),
(2, 'Metales', 'herramientas y otros'),
(3, 'Pintura', 'Todo en pintura de aceite y de agua'),
(4, 'Otros', 'Otros');

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
  `cliente_telefono` varchar(20) DEFAULT NULL,
  `cliente_direccion` varchar(100) NOT NULL,
  PRIMARY KEY (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallefactura`
--

DROP TABLE IF EXISTS `detallefactura`;
CREATE TABLE IF NOT EXISTS `detallefactura` (
  `productos_product_ID` int(10) UNSIGNED NOT NULL,
  `factura_factura_ID` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  KEY `fk_detalleFactura_productos1_idx` (`productos_product_ID`),
  KEY `fk_detalleFactura_factura1_idx` (`factura_factura_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temporal`
--

DROP TABLE IF EXISTS `detalle_temporal`;
CREATE TABLE IF NOT EXISTS `detalle_temporal` (
  `id_det_temp` int(11) NOT NULL AUTO_INCREMENT,
  `token_user` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_producto` decimal(10,2) NOT NULL,
  `productos_product_ID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_det_temp`),
  KEY `fk_detalle_temporal_productos1_idx` (`productos_product_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

DROP TABLE IF EXISTS `factura`;
CREATE TABLE IF NOT EXISTS `factura` (
  `factura_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `factura_fecha` datetime NOT NULL,
  `factura_total` decimal(20,2) UNSIGNED NOT NULL,
  `cliente_cliente_id` int(10) UNSIGNED NOT NULL,
  `factura_descuento` decimal(10,2) DEFAULT NULL,
  `sucursal_sucursal_ID` int(10) UNSIGNED NOT NULL,
  `factura_estado` int(11) NOT NULL,
  PRIMARY KEY (`factura_ID`),
  KEY `fk_factura_cliente1_idx` (`cliente_cliente_id`),
  KEY `fk_factura_sucursal1_idx` (`sucursal_sucursal_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `categorias_productos_cat_product_ID` int(10) UNSIGNED NOT NULL,
  `unidad_medida_unidad_medida_id` int(11) NOT NULL,
  `proveedores_provee_ID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`product_ID`),
  KEY `fk_productos_categorias_productos_idx` (`categorias_productos_cat_product_ID`),
  KEY `fk_productos_unidad_medida1_idx` (`unidad_medida_unidad_medida_id`),
  KEY `fk_productos_proveedores1_idx` (`proveedores_provee_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`product_ID`, `product_nombre`, `product_cantidad`, `product_precio`, `product_descripcion`, `product_foto`, `categorias_productos_cat_product_ID`, `unidad_medida_unidad_medida_id`, `proveedores_provee_ID`) VALUES
(1, 'Martillo', 100, '200.00', 'Martillo truper de acero', '48ca_852.jpeg', 2, 1, 1),
(2, 'Salbutamol', 10, '100.00', 'Jarabe para la tos', '4783f_785.jpeg', 4, 1, 3);

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`provee_ID`, `provee_nombre`, `provee_direccion`, `provee_telefono`, `sucursal_sucursal_ID`) VALUES
(1, 'LujoMax', 'Ocotal', '87675468', 1),
(2, 'EduCax', 'Managua', '87364374', 1),
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
  `ser_nombre` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_descripcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ser_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ser_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ser_id`, `ser_nombre`, `ser_descripcion`, `ser_img`) VALUES
(3, 'Fontanería', 'Asesoría en instalación de tuberia', 'sin foto');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicio_sucursal`
--

INSERT INTO `servicio_sucursal` (`servicio_fk`, `sucursal_fk`) VALUES
(3, 1);

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
  PRIMARY KEY (`sucursal_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`sucursal_ID`, `sucursal_nombre`, `sucursal_telefono`, `sucursal_correo`) VALUES
(1, 'Ferreteria San Luis', '87654321', 'SanLuis@gmail.com'),
(2, 'Farmacia Divina', '87654321', 'Divina@gmail.com');

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
  ADD CONSTRAINT `fk_admin_roles1` FOREIGN KEY (`roles_rol_ID`) REFERENCES `roles` (`rol_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `admin_sucursal`
--
ALTER TABLE `admin_sucursal`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`fk_admin`) REFERENCES `admin` (`admin_ID`),
  ADD CONSTRAINT `fk_sucursal` FOREIGN KEY (`fk_sucursal`) REFERENCES `sucursal` (`sucursal_ID`);

--
-- Filtros para la tabla `detallefactura`
--
ALTER TABLE `detallefactura`
  ADD CONSTRAINT `fk_detalleFactura_factura1` FOREIGN KEY (`factura_factura_ID`) REFERENCES `factura` (`factura_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalleFactura_productos1` FOREIGN KEY (`productos_product_ID`) REFERENCES `productos` (`product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_temporal`
--
ALTER TABLE `detalle_temporal`
  ADD CONSTRAINT `fk_detalle_temporal_productos1` FOREIGN KEY (`productos_product_ID`) REFERENCES `productos` (`product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_cliente1` FOREIGN KEY (`cliente_cliente_id`) REFERENCES `cliente` (`cliente_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_sucursal1` FOREIGN KEY (`sucursal_sucursal_ID`) REFERENCES `sucursal` (`sucursal_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categorias_productos` FOREIGN KEY (`categorias_productos_cat_product_ID`) REFERENCES `categorias_productos` (`cat_product_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_proveedores1` FOREIGN KEY (`proveedores_provee_ID`) REFERENCES `proveedores` (`provee_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_productos_unidad_medida1` FOREIGN KEY (`unidad_medida_unidad_medida_id`) REFERENCES `unidad_medida` (`unidad_medida_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
