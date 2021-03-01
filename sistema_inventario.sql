-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-03-2021 a las 23:18:59
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

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `procedimiento_datos_generales`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `procedimiento_datos_generales` (IN `id_suc` VARCHAR(10))  BEGIN
	DECLARE cantidad int;    
    DECLARE precio decimal;
    
	DECLARE valor_total decimal;
    DECLARE precio_total INT;
    
    DECLARE total_producto int;
    DECLARE total_cliente int;
    DECLARE total_trabajadores int;
    
    DECLARE calculo_total CURSOR FOR 
    	SELECT p.product_cantidad , p.product_precio 
        FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID
		INNER JOIN sucursal AS s ON pr.sucursal_sucursal_ID = s.sucursal_ID
		WHERE s.sucursal_ID = id_suc;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET @hecho = true;
    
    SET valor_total = 0;
    SET precio_total = 0;
    
    OPEN calculo_total;
    
    loop1: LOOP
    
    	FETCH calculo_total INTO cantidad, precio;
        
        
        IF @hecho THEN
        	LEAVE loop1;
        END IF;
        
        SET precio_total = cantidad * precio;
        SET valor_total =  valor_total + precio_total;
        
    END LOOP loop1;
    CLOSE calculo_total;
    
    SELECT COUNT(*)
	FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID
	INNER JOIN sucursal AS s ON pr.sucursal_sucursal_ID = s.sucursal_ID
	WHERE s.sucursal_ID = id_suc INTO total_producto;
	SELECT COUNT(*)
	FROM cliente AS c INNER JOIN sucursal AS s ON c.fk_sucursal_cliente = s.sucursal_ID
	WHERE s.sucursal_ID = id_suc INTO total_cliente;
	SELECT COUNT(*)
	FROM admin AS a INNER JOIN sucursal AS s ON a.sucursal_sucursal_ID = s.sucursal_ID
	WHERE s.sucursal_ID = id_suc && a.roles_rol_ID <> 1 INTO total_trabajadores;
    
    SELECT valor_total AS precio_t, total_producto, total_cliente, total_trabajadores;
END$$

DELIMITER ;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`admin_ID`, `admin_nombre`, `admin_apellido`, `admin_usuario`, `admin_direccion`, `admin_telefono`, `admin_correo`, `admin_pass`, `roles_rol_ID`, `sucursal_sucursal_ID`) VALUES
(1, 'Byron Antonio', 'Navarrete Cañada', 'BayNavCan', 'Somoto - Madriz', '+505 8736-4374', 'navarretebay74@gmail.com', '$2y$10$MFnUkg8FHvdweL8VFuq8..as2CLKQH9HVnDNKVapUIlfv8.kiLcEe', 1, 1),
(2, 'Angel', 'Navarrete', 'AngNavCan', 'Somoto', '+505 8765-4321', 'idashlevel@gmail.com', '$2y$10$EDORcOWofk2Rbn024jcgROuPypIYc6BJKFAapq.ln5I3Frrt2CHza', 1, 2),
(6, 'Sait', 'Navarrete', 'SaitNavCan', 'Somoto', '+505 8765-4321', 'sait@gmail.com', '$2y$10$qUOm6i.rJ6rTF63HieikzOLRfDWX8blI8G9qhy.kPQZs53vZ7M1fO', 2, 1),
(7, 'Kevin', 'Jimenez', 'KevJim', 'Somoto', '+505 8765-4321', 'KevinJimenez@gmail.com', '$2y$10$YRZ.zvysRa5lMk5qP3pkjOhDR57gImhvBgslLBk6VKPvN7z6hTkYy', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_productos`
--

DROP TABLE IF EXISTS `categorias_productos`;
CREATE TABLE IF NOT EXISTS `categorias_productos` (
  `cat_product_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID de la categia del producto',
  `cat_product_nombre` varchar(45) NOT NULL COMMENT 'nombre de la categoria del producto',
  `cat_product_descripcion` varchar(45) DEFAULT NULL COMMENT 'descripcion de la categoria del producto',
  PRIMARY KEY (`cat_product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias_productos`
--

INSERT INTO `categorias_productos` (`cat_product_ID`, `cat_product_nombre`, `cat_product_descripcion`) VALUES
(15, 'Construcción', ''),
(16, 'Madera', ''),
(17, 'Electricidad', ''),
(18, 'Herramientas Baño y fontanería', ''),
(19, 'Cocina', ''),
(20, 'Jardín', ''),
(21, 'Ferretería', ''),
(22, 'Pintura', ''),
(23, 'Decoración', ''),
(24, 'Mobiliario y ordenación', ''),
(25, 'Climatización', ''),
(26, 'Herramientas', NULL),
(35, 'Otros', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`product_ID`, `product_nombre`, `product_cantidad`, `product_precio`, `product_descripcion`, `product_foto`, `product_marca`, `categorias_productos_cat_product_ID`, `unidad_medida_unidad_medida_id`, `proveedores_provee_ID`) VALUES
(11, 'Martillo', 10, '200.00', 'Martillo de 16 onzas', '73721_597.jpeg', NULL, 26, 4, 1),
(12, 'Clavos 4 pul', 100, '15.00', 'Acindar clavos punta paris 4 pulgadas', '431un_875.png', NULL, 21, 6, 1),
(13, 'Sierra Circula', 20, '1200.00', 'Makita - HS7600 sierra circular 7-1/4 pulgadas', '50871_90.jpeg', NULL, 26, 4, 1),
(14, 'Barra', 30, '800.00', 'Barra Truper 7/8X4&#039;10753', '283HE_621.jpeg', NULL, 26, 4, 1),
(15, 'Extension', 30, '600.00', 'CABLE DE EXTENSIÓN PARA EXTERIORES DE 7,6 M (25 PIES)', '463un_673.jpeg', NULL, 17, 4, 1),
(16, 'Extensión Múltiple', 50, '450.00', 'Enchufe De Extensión Y Cable De Extensión De Múltiples', '189Hc_895.jpeg', NULL, 17, 4, 1),
(17, 'Mazo', 40, '300.00', 'Mazo,Peso de la Cabeza 16 oz.', '5232Z_239.jpeg', NULL, 26, 4, 1),
(18, 'Zinc', 50, '250.00', 'LAMINA DE ZINC ONDULADO', '86b3_16.png', NULL, 15, 4, 1),
(19, 'Puerta de Metal', 30, '1300.00', 'Puerta de Metal Super Briko ', '38340_664.jpeg', NULL, 15, 4, 1),
(20, 'Ventana Francesa', 35, '1400.00', 'Ventana francesa blanca de pvc de 60 x 60 cm', '712ve_305.jpeg', NULL, 15, 4, 1),
(21, 'Escalera', 20, '700.00', 'Escaleras de aluminio simple Aries', '249P1_221.jpeg', NULL, 26, 4, 1),
(22, 'Lámpara', 100, '100.00', 'Lámpara fluorescente', '18526_211.jpeg', NULL, 17, 4, 1),
(23, 'Taladro', 10, '1500.00', 'TALADRO/ATORNILLADOR DEWALT DE 1/2 PULGADA', '20860_314.jpeg', NULL, 26, 4, 1),
(25, 'Cemento', 20, '300.00', 'Cemento de buena calidad', '715Ce_83.jpeg', NULL, 15, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proforma`
--

DROP TABLE IF EXISTS `proforma`;
CREATE TABLE IF NOT EXISTS `proforma` (
  `proforma_ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `proforma_productos` text COLLATE utf8_spanish_ci NOT NULL,
  `proforma_estado` tinyint(1) DEFAULT 0,
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`provee_ID`, `provee_nombre`, `provee_direccion`, `provee_telefono`, `sucursal_sucursal_ID`) VALUES
(1, 'LujoMax', 'Ocotal', '87675468', 1),
(3, 'FarmaCox', 'Ocotal', '87654214', 2),
(7, 'EduCax', 'Somoto', '87364374', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`ser_id`, `ser_nombre`, `ser_descripcion`, `ser_img`) VALUES
(3, 'Fontanería', 'Asesoría en instalación de tuberia', 'sin foto'),
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
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sucursal_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`sucursal_ID`, `sucursal_nombre`, `sucursal_telefono`, `sucursal_correo`, `sucursal_direccion`, `activo`, `logo`) VALUES
(1, 'Ferreteria San Luis', '87654321', 'SanLuis@gmail.com', 'Somoto, de enitel 1 C. al Norte', 1, 'logo.png'),
(2, 'Ferreteria Divino niño', '87654321', 'Divina@gmail.com', 'Ocotal', 0, 'logo.png');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`unidad_medida_id`, `unidad_medida_tipo`, `unidad_medida_nombre`, `unidad_medida_abreviatura`) VALUES
(3, 'Metro', 'metro', 'mts'),
(4, 'Unidad', 'unidad', 'und'),
(5, 'Galon', 'galon', 'gal'),
(6, 'Libra', 'libra', 'lb'),
(7, 'Pliego', 'pliego', 'plg'),
(8, 'Lamina', 'lamina', 'lmn'),
(9, 'Rollo', 'rollo', 'roll');

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
