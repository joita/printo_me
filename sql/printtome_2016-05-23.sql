# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.38)
# Base de datos: printtome
# Tiempo de Generación: 2016-05-23 17:37:08 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla CaracteristicasAdicionales
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CaracteristicasAdicionales`;

CREATE TABLE `CaracteristicasAdicionales` (
  `id_caracteristica` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_caracteristica` varchar(100) NOT NULL,
  `nombre_caracteristica_slug` varchar(100) NOT NULL,
  `id_caracteristica_parent` int(11) DEFAULT '0' COMMENT '0 - grupo de la caracteristica',
  `id_tipo` int(11) NOT NULL,
  `estatus` int(1) DEFAULT '1',
  PRIMARY KEY (`id_caracteristica`),
  UNIQUE KEY `id_caracteristica_UNIQUE` (`id_caracteristica`),
  KEY `fk_CaracteristicasAdicionales_TiposDeProducto1_idx` (`id_tipo`),
  CONSTRAINT `fk_CaracteristicasAdicionales_TiposDeProducto1` FOREIGN KEY (`id_tipo`) REFERENCES `TiposDeProducto` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `CaracteristicasAdicionales` WRITE;
/*!40000 ALTER TABLE `CaracteristicasAdicionales` DISABLE KEYS */;

INSERT INTO `CaracteristicasAdicionales` (`id_caracteristica`, `nombre_caracteristica`, `nombre_caracteristica_slug`, `id_caracteristica_parent`, `id_tipo`, `estatus`)
VALUES
	(2,'Tipo de cuello','tipo-de-cuello',0,4,1),
	(3,'Cuello redondo','cuello-redondo',2,4,1),
	(4,'Cuello V','cuello-v',2,4,1),
	(5,'Tipo de manga','tipo-de-manga',0,4,1),
	(6,'Manga corta','manga-corta',5,4,1),
	(7,'Manga larga','manga-larga',5,4,1),
	(8,'Sin manga','sin-manga',5,4,1);

/*!40000 ALTER TABLE `CaracteristicasAdicionales` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla CatalogoProductos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CatalogoProductos`;

CREATE TABLE `CatalogoProductos` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_producto` varchar(100) NOT NULL,
  `nombre_producto_slug` varchar(100) NOT NULL,
  `modelo_producto` varchar(100) NOT NULL,
  `modelo_producto_slug` varchar(100) NOT NULL,
  `descripcion_producto` text,
  `precio_producto` double(12,2) NOT NULL DEFAULT '0.00',
  `descuento_especifico` double(12,2) DEFAULT '0.00',
  `peso_producto` double(12,2) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '1 - activo, 0 - inactivo, 33 - borrado',
  `envio_gratis` int(11) NOT NULL DEFAULT '0' COMMENT '0 - no aplica, 1 - si aplica',
  `aplica_devolucion` int(11) NOT NULL DEFAULT '0' COMMENT '0 - no aplica, 1 - si aplica',
  `id_tipo` int(11) DEFAULT NULL,
  `id_marca` int(11) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) DEFAULT NULL,
  `veces_abierto` bigint(20) DEFAULT '0',
  `caracteristicas_adicionales` text,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `id_producto_UNIQUE` (`id_producto`),
  KEY `fk_CatalogoProductos_Categorias1_idx` (`id_categoria`),
  KEY `fk_CatalogoProductos_Marcas1_idx` (`id_marca`),
  KEY `fk_CatalogoProductos_TiposDeProducto1_idx` (`id_tipo`),
  CONSTRAINT `fk_CatalogoProductos_Categorias1` FOREIGN KEY (`id_categoria`) REFERENCES `Categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CatalogoProductos_Marcas1` FOREIGN KEY (`id_marca`) REFERENCES `Marcas` (`id_marca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CatalogoProductos_TiposDeProducto1` FOREIGN KEY (`id_tipo`) REFERENCES `TiposDeProducto` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `CatalogoProductos` WRITE;
/*!40000 ALTER TABLE `CatalogoProductos` DISABLE KEYS */;

INSERT INTO `CatalogoProductos` (`id_producto`, `nombre_producto`, `nombre_producto_slug`, `modelo_producto`, `modelo_producto_slug`, `descripcion_producto`, `precio_producto`, `descuento_especifico`, `peso_producto`, `estatus`, `envio_gratis`, `aplica_devolucion`, `id_tipo`, `id_marca`, `id_categoria`, `id_subcategoria`, `veces_abierto`, `caracteristicas_adicionales`)
VALUES
	(1,'Playera deportiva','playera-deportiva','1212','1212','Plae',0.00,0.00,NULL,1,0,0,4,1,8,NULL,0,'{\"tipo-de-cuello\":\"cuello-v\",\"tipo-de-manga\":\"manga-corta\"}');

/*!40000 ALTER TABLE `CatalogoProductos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla CatalogoSkuPorProducto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CatalogoSkuPorProducto`;

CREATE TABLE `CatalogoSkuPorProducto` (
  `id_sku` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(200) NOT NULL,
  `caracteristicas` varchar(1000) DEFAULT NULL,
  `cantidad_inicial` int(11) DEFAULT NULL,
  `cantidad_minima` int(11) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '0 - inactivo, 1 - activo',
  `id_color` int(11) NOT NULL,
  `precio` double(12,2) NOT NULL,
  PRIMARY KEY (`id_sku`),
  UNIQUE KEY `id_sku_UNIQUE` (`id_sku`),
  KEY `fk_CatalogoSkuPorProducto_ColoresPorProducto1_idx` (`id_color`),
  CONSTRAINT `fk_CatalogoSkuPorProducto_ColoresPorProducto1` FOREIGN KEY (`id_color`) REFERENCES `ColoresPorProducto` (`id_color`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `CatalogoSkuPorProducto` WRITE;
/*!40000 ALTER TABLE `CatalogoSkuPorProducto` DISABLE KEYS */;

INSERT INTO `CatalogoSkuPorProducto` (`id_sku`, `sku`, `caracteristicas`, `cantidad_inicial`, `cantidad_minima`, `estatus`, `id_color`, `precio`)
VALUES
	(1,'1212MBlanco con negro','{\"talla\":\"M\"}',10,1,1,1,0.00);

/*!40000 ALTER TABLE `CatalogoSkuPorProducto` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla Categorias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Categorias`;

CREATE TABLE `Categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(50) NOT NULL,
  `nombre_categoria_slug` varchar(50) NOT NULL,
  `id_categoria_parent` int(11) DEFAULT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1' COMMENT '0 - inactivo, 1 - activo',
  `custom` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `id_categoria_UNIQUE` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Categorias` WRITE;
/*!40000 ALTER TABLE `Categorias` DISABLE KEYS */;

INSERT INTO `Categorias` (`id_categoria`, `nombre_categoria`, `nombre_categoria_slug`, `id_categoria_parent`, `titulo`, `descripcion`, `estatus`, `custom`)
VALUES
	(8,'Playeras','playeras',0,NULL,NULL,1,0),
	(9,'prueba','prueba',8,NULL,NULL,1,0);

/*!40000 ALTER TABLE `Categorias` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL COMMENT 'clipart, font',
  `title` varchar(200) NOT NULL,
  `layout` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `level` int(3) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `image` text NOT NULL,
  `parent_id` int(10) NOT NULL,
  `published` varchar(1) NOT NULL,
  `language` varchar(5) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `created` datetime NOT NULL,
  `order` int(4) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Clientes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Clientes`;

CREATE TABLE `Clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(200) NOT NULL,
  `apellidos` varchar(200) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `token_activacion_correo` varchar(1000) DEFAULT NULL,
  `password` varchar(1000) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `foto_perfil_original` varchar(100) DEFAULT NULL,
  `foto_perfil_grande` varchar(100) DEFAULT NULL,
  `foto_perfil_chica` varchar(100) DEFAULT NULL,
  `facebook_id` varchar(100) DEFAULT NULL,
  `token_facebook` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `id_cliente_UNIQUE` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Clientes` WRITE;
/*!40000 ALTER TABLE `Clientes` DISABLE KEYS */;

INSERT INTO `Clientes` (`id_cliente`, `nombres`, `apellidos`, `email`, `token_activacion_correo`, `password`, `fecha_registro`, `fecha_nacimiento`, `genero`, `foto_perfil_original`, `foto_perfil_grande`, `foto_perfil_chica`, `facebook_id`, `token_facebook`)
VALUES
	(12,'henry','silva bautista','henry_silva_b@hotmail.com','activado','922251de960097716bd06623826fdc9480317328a7e987d794e5847d608f1b9dcd7deef57be05c011f8d6ddf75a2ee8348912f35ebb716087d14ac64ec96a672wDAdR/t+hby2Y77U5YibL7RLuIFmves7wWnQpzXtGEw=','2016-05-20 18:49:03','1988-07-07','M',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `Clientes` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla cliparts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cliparts`;

CREATE TABLE `cliparts` (
  `clipart_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cate_id` int(11) NOT NULL,
  `add_price` varchar(1) NOT NULL DEFAULT '0',
  `status` varchar(2) NOT NULL DEFAULT '1' COMMENT '1. display, 0. pending, -1. deny',
  `feature` int(1) NOT NULL DEFAULT '0',
  `copyright` int(1) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL COMMENT 'photo, icon, vertor',
  `fle_url` text NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(200) NOT NULL,
  `colors` text NOT NULL,
  `change_color` int(1) NOT NULL DEFAULT '0',
  `view` int(100) NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `remove` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`clipart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla colores
# ------------------------------------------------------------

DROP TABLE IF EXISTS `colores`;

CREATE TABLE `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hex` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `published` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Volcado de tabla ColoresPorProducto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ColoresPorProducto`;

CREATE TABLE `ColoresPorProducto` (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_color` varchar(50) NOT NULL,
  `nombre_color` varchar(100) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '0 - inactivo, 1 - activo, 33 - borrado',
  `id_producto` int(11) NOT NULL,
  `colores_adicionales` varchar(250) DEFAULT NULL,
  `precio` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_color`),
  UNIQUE KEY `id_color_UNIQUE` (`id_color`),
  KEY `fk_ColoresPorProducto_CatalogoProductos1_idx` (`id_producto`),
  CONSTRAINT `fk_ColoresPorProducto_CatalogoProductos1` FOREIGN KEY (`id_producto`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `ColoresPorProducto` WRITE;
/*!40000 ALTER TABLE `ColoresPorProducto` DISABLE KEYS */;

INSERT INTO `ColoresPorProducto` (`id_color`, `codigo_color`, `nombre_color`, `estatus`, `id_producto`, `colores_adicionales`, `precio`)
VALUES
	(1,'#FFFFFF','Blanco con negro',1,1,NULL,100.00);

/*!40000 ALTER TABLE `ColoresPorProducto` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla Configuracion
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Configuracion`;

CREATE TABLE `Configuracion` (
  `id_configuracion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_configuracion` varchar(100) NOT NULL,
  `nombre_configuracion_slug` varchar(100) NOT NULL,
  `tipo_valor` varchar(200) DEFAULT NULL,
  `valor_configuracion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_configuracion`),
  UNIQUE KEY `id_configuracion_UNIQUE` (`id_configuracion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Cotizador
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Cotizador`;

CREATE TABLE `Cotizador` (
  `id_cotizador` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_tinta` int(11) DEFAULT NULL COMMENT '	',
  `costo_blanca` double(10,2) DEFAULT NULL,
  `costo_color` double(10,2) DEFAULT NULL,
  `tecnica` varchar(45) DEFAULT NULL,
  `multiplicador_1` double(10,2) DEFAULT NULL,
  `multiplicador_2` double(10,2) DEFAULT NULL,
  `tipo_estampado` varchar(45) DEFAULT NULL,
  `cantidad_max` int(11) NOT NULL,
  `cantidad_min` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT '1',
  PRIMARY KEY (`id_cotizador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Cotizador` WRITE;
/*!40000 ALTER TABLE `Cotizador` DISABLE KEYS */;

INSERT INTO `Cotizador` (`id_cotizador`, `tipo_tinta`, `costo_blanca`, `costo_color`, `tecnica`, `multiplicador_1`, `multiplicador_2`, `tipo_estampado`, `cantidad_max`, `cantidad_min`, `estatus`)
VALUES
	(1,1,32.00,35.00,'DTG',2.75,1.75,'1',1,1,1),
	(2,1,32.00,35.00,'DTG',2.60,1.65,'1',2,2,1),
	(3,1,32.00,35.00,'DTG',2.45,1.55,'1',3,3,1),
	(4,1,32.00,35.00,'DTG',2.30,1.50,'1',4,4,1),
	(5,1,32.00,35.00,'DTG',2.15,1.50,'1',5,5,1),
	(6,1,31.00,31.00,'SERI',2.05,1.50,'1',9,6,1),
	(7,1,28.00,28.00,'SERI',1.95,1.50,'1',19,10,1),
	(8,1,16.00,16.00,'SERI',1.70,1.50,'1',29,20,1),
	(9,1,13.00,13.00,'SERI',1.70,1.50,'1',39,30,1),
	(10,1,12.00,12.00,'SERI',1.70,1.50,'1',49,40,1),
	(11,1,10.00,10.00,'SERI',1.70,1.50,'1',99,50,1),
	(12,1,9.00,9.00,'SERI',1.70,1.50,'1',199,100,1),
	(13,1,8.50,8.50,'SERI',1.70,1.50,'1',499,200,1),
	(14,1,8.00,8.00,'SERI',1.70,1.50,'1',999,500,1),
	(15,1,8.00,8.00,'SERI',1.70,1.50,'1',1000,1000,1),
	(16,2,34.00,37.00,'DTG',2.75,1.75,'1',1,1,1),
	(17,2,34.00,37.00,'DTG',2.60,1.65,'1',2,2,1),
	(18,2,34.00,37.00,'DTG',2.45,1.55,'1',3,3,1),
	(19,2,34.00,37.00,'DTG',2.30,1.50,'1',4,4,1),
	(20,2,34.00,37.00,'DTG',2.15,1.50,'1',5,5,1),
	(21,2,34.00,37.00,'DTG',2.05,1.50,'1',9,6,1),
	(22,2,30.00,33.00,'DTG',1.95,1.50,'1',19,10,1),
	(23,2,26.00,28.00,'SERI',1.70,1.50,'1',29,20,1),
	(24,2,23.00,23.00,'SERI',1.70,1.50,'1',39,30,1),
	(25,2,20.00,20.00,'SERI',1.70,1.50,'1',49,40,1),
	(26,2,18.50,18.50,'SERI',1.70,1.50,'1',99,50,1),
	(27,2,16.00,16.00,'SERI',1.70,1.50,'1',199,100,1),
	(28,2,15.50,15.50,'SERI',1.70,1.50,'1',499,200,1),
	(29,2,14.50,14.50,'SERI',1.70,1.50,'1',999,500,1),
	(30,2,13.50,13.50,'SERI',1.70,1.50,'1',1000,1000,1),
	(31,3,36.00,39.00,'DTG',2.75,1.75,'1',1,1,1),
	(32,3,36.00,39.00,'DTG',2.60,1.65,'1',2,2,1),
	(33,3,36.00,39.00,'DTG',2.45,1.55,'1',3,3,1),
	(34,3,36.00,39.00,'DTG',2.30,1.50,'1',4,4,1),
	(35,3,36.00,39.00,'DTG',2.15,1.50,'1',5,5,1),
	(36,3,36.00,39.00,'DTG',2.05,1.50,'1',9,6,1),
	(37,3,32.00,35.00,'DTG',1.95,1.50,'1',19,10,1),
	(38,3,31.00,31.00,'SERI',1.70,1.50,'1',29,20,1),
	(39,3,29.00,29.00,'SERI',1.70,1.50,'1',39,30,1),
	(40,3,26.00,26.00,'SERI',1.70,1.50,'1',49,40,1),
	(41,3,23.00,23.00,'SERI',1.70,1.50,'1',99,50,1),
	(42,3,20.00,20.00,'SERI',1.70,1.50,'1',199,100,1),
	(43,3,19.00,19.00,'SERI',1.70,1.50,'1',499,200,1),
	(44,3,18.00,18.00,'SERI',1.70,1.50,'1',999,500,1),
	(45,3,17.50,17.50,'SERI',1.70,1.50,'1',1000,1000,1),
	(46,4,40.00,40.00,'DTG',2.75,1.75,'1',1,1,1),
	(47,4,40.00,40.00,'DTG',2.60,1.65,'1',2,2,1),
	(48,4,40.00,40.00,'DTG',2.45,1.55,'1',3,3,1),
	(49,4,40.00,40.00,'DTG',2.30,1.50,'1',4,4,1),
	(50,4,40.00,40.00,'DTG',2.15,1.50,'1',5,5,1),
	(51,4,40.00,40.00,'DTG',2.05,1.50,'1',9,6,1),
	(52,4,40.00,40.00,'DTG',1.95,1.50,'1',19,10,1),
	(53,4,40.00,40.00,'DTG',1.70,1.50,'1',29,20,1),
	(54,4,40.00,40.00,'DTG',1.70,1.50,'1',39,30,1),
	(55,4,40.00,40.00,'DTG',1.70,1.50,'1',49,40,1),
	(56,4,40.00,40.00,'DTG',1.70,1.50,'1',99,50,1),
	(57,4,40.00,40.00,'DTG',1.70,1.50,'1',199,100,1),
	(58,4,40.00,40.00,'DTG',1.70,1.50,'1',499,200,1),
	(59,4,40.00,40.00,'DTG',1.70,1.50,'1',999,500,1),
	(60,4,40.00,40.00,'DTG',1.70,1.50,'1',1000,1000,1),
	(61,1,0.00,24.00,'VINIL',2.75,1.75,'2',1,1,1),
	(62,1,0.00,23.50,'VINIL',2.60,1.65,'2',2,2,1),
	(63,1,0.00,22.00,'VINIL',2.50,1.55,'2',3,3,1),
	(64,1,0.00,21.50,'VINIL',2.35,1.50,'2',4,4,1),
	(65,1,0.00,21.00,'VINIL',2.25,1.50,'2',5,5,1),
	(66,1,0.00,18.00,'SERI',2.15,1.50,'2',9,6,1),
	(67,1,0.00,14.00,'SERI',2.05,1.50,'2',19,10,1),
	(68,1,0.00,12.00,'SERI',2.00,1.50,'2',29,20,1),
	(69,1,0.00,10.00,'SERI',2.00,1.50,'2',39,30,1),
	(70,1,0.00,8.00,'SERI',2.00,1.50,'2',49,40,1),
	(71,1,0.00,5.00,'SERI',2.00,1.50,'2',99,50,1),
	(72,1,0.00,4.50,'SERI',2.00,1.50,'2',199,100,1),
	(73,1,0.00,4.00,'SERI',2.00,1.50,'2',499,200,1),
	(74,1,0.00,4.00,'SERI',2.00,1.50,'2',999,500,1),
	(75,1,0.00,4.00,'SERI',2.00,1.50,'2',1000,1000,1),
	(76,2,0.00,27.00,'TDG',2.75,1.75,'2',1,1,1),
	(77,2,0.00,27.00,'TDG',2.60,1.65,'2',2,2,1),
	(78,2,0.00,27.00,'TDG',2.50,1.55,'2',3,3,1),
	(79,2,0.00,27.00,'TDG',2.35,1.50,'2',4,4,1),
	(80,2,0.00,27.00,'TDG',2.25,1.50,'2',5,5,1),
	(81,2,0.00,27.00,'TDG',2.15,1.50,'2',9,6,1),
	(82,2,0.00,23.00,'TDG',2.05,1.50,'2',19,10,1),
	(83,2,0.00,23.00,'TDG',2.00,1.50,'2',29,20,1),
	(84,2,0.00,22.00,'SERI',2.00,1.50,'2',39,30,1),
	(85,2,0.00,20.00,'SERI',2.00,1.50,'2',49,40,1),
	(86,2,0.00,17.00,'SERI',2.00,1.50,'2',99,50,1),
	(87,2,0.00,16.50,'SERI',2.00,1.50,'2',199,100,1),
	(88,2,0.00,12.00,'SERI',2.00,1.50,'2',499,200,1),
	(89,2,0.00,10.00,'SERI',2.00,1.50,'2',999,500,1),
	(90,2,0.00,9.50,'SERI',2.00,1.50,'2',1000,1000,1),
	(91,3,0.00,27.00,'TDG',2.75,1.75,'2',1,1,1),
	(92,3,0.00,27.00,'TDG',2.60,1.65,'2',2,2,1),
	(93,3,0.00,27.00,'TDG',2.50,1.55,'2',3,3,1),
	(94,3,0.00,27.00,'TDG',2.35,1.50,'2',4,4,1),
	(95,3,0.00,27.00,'TDG',2.25,1.50,'2',5,5,1),
	(96,3,0.00,27.00,'TDG',2.15,1.50,'2',9,6,1),
	(97,3,0.00,23.00,'TDG',2.05,1.50,'2',19,10,1),
	(98,3,0.00,23.00,'TDG',2.00,1.50,'2',29,20,1),
	(99,3,0.00,23.00,'TDG',2.00,1.50,'2',39,30,1),
	(100,3,0.00,23.00,'TDG',2.00,1.50,'2',49,40,1),
	(101,3,0.00,19.00,'TDG',2.00,1.50,'2',99,50,1),
	(102,3,0.00,19.00,'TDG',2.00,1.50,'2',199,100,1),
	(103,3,0.00,14.00,'SERI',2.00,1.50,'2',499,200,1),
	(104,3,0.00,12.00,'SERI',2.00,1.50,'2',999,500,1),
	(105,3,NULL,11.00,'SERI',2.00,1.50,'2',1000,1000,1),
	(106,4,24.00,27.00,'',2.75,1.75,'2',1,1,1),
	(107,4,24.00,27.00,'',2.60,1.65,'2',2,2,1),
	(108,4,24.00,27.00,'',2.50,1.55,'2',3,3,1),
	(109,4,24.00,27.00,'',2.35,1.50,'2',4,4,1),
	(110,4,24.00,27.00,'',2.25,1.50,'2',5,5,1),
	(111,4,24.00,27.00,'',2.15,1.50,'2',9,6,1),
	(112,4,21.00,23.00,'',2.05,1.50,'2',19,10,1),
	(113,4,21.00,23.00,'',2.00,1.50,'2',29,20,1),
	(114,4,21.00,23.00,'',2.00,1.50,'2',39,30,1),
	(115,4,21.00,23.00,'',2.00,1.50,'2',49,40,1),
	(116,4,18.00,19.00,'',2.00,1.50,'2',99,50,1),
	(117,4,18.00,19.00,'',2.00,1.50,'2',199,100,1),
	(118,4,18.00,19.00,'',2.00,1.50,'2',499,200,1),
	(119,4,18.00,19.00,'',2.00,1.50,'2',999,500,1),
	(120,4,18.00,19.00,'',2.00,1.50,'2',1000,1000,1),
	(121,1,0.00,0.00,'TDG',0.00,0.00,'1',0,0,33),
	(122,1,0.00,0.00,'TDG',0.00,0.00,'1',0,0,33),
	(123,1,0.00,0.00,'TDG',0.00,0.00,'1',0,0,33),
	(124,1,0.00,0.00,'TDG',0.00,0.00,'1',0,0,33),
	(125,1,0.00,0.00,'TDG',0.00,0.00,'1',0,0,33),
	(126,1,121.00,121.00,'SERI',29.00,12.00,'1',121,19212,33);

/*!40000 ALTER TABLE `Cotizador` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla Creditos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Creditos`;

CREATE TABLE `Creditos` (
  `id_credito` int(11) NOT NULL AUTO_INCREMENT,
  `monto_credito` double(12,2) NOT NULL,
  `motivo` text,
  `descripcion_uso` text,
  `fecha_creacion` datetime NOT NULL,
  `fecha_uso` datetime DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '0' COMMENT '0 - pendiente, 1 - usado, 33 - borrado',
  `id_cliente` int(11) NOT NULL,
  `minimo_compra` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_credito`),
  UNIQUE KEY `id_credito_UNIQUE` (`id_credito`),
  KEY `fk_Creditos_Clientes1_idx` (`id_cliente`),
  CONSTRAINT `fk_Creditos_Clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Cupones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Cupones`;

CREATE TABLE `Cupones` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `descripcion` text,
  `cupon` varchar(50) NOT NULL DEFAULT '',
  `porcentual` tinyint(1) DEFAULT '0',
  `descuento` double(12,2) DEFAULT NULL,
  `expira` datetime DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `estatus` int(2) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT 'Promocion',
  `id_cliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Devoluciones
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Devoluciones`;

CREATE TABLE `Devoluciones` (
  `id_devolucion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_devolucion` datetime NOT NULL,
  `id_pedido` bigint(20) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '0' COMMENT '0 - pendiente, 1 - realizada, 33 - cancelada',
  PRIMARY KEY (`id_devolucion`),
  UNIQUE KEY `id_devolucion_UNIQUE` (`id_devolucion`),
  UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`),
  KEY `fk_Devoluciones_Pedidos1_idx` (`id_pedido`),
  CONSTRAINT `fk_Devoluciones_Pedidos1` FOREIGN KEY (`id_pedido`) REFERENCES `Pedidos` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla DireccionesPorCliente
# ------------------------------------------------------------

DROP TABLE IF EXISTS `DireccionesPorCliente`;

CREATE TABLE `DireccionesPorCliente` (
  `id_direccion` int(11) NOT NULL AUTO_INCREMENT,
  `identificador_direccion` varchar(100) NOT NULL,
  `linea1` varchar(200) NOT NULL,
  `linea2` varchar(200) DEFAULT NULL,
  `codigo_postal` varchar(20) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `pais` varchar(45) DEFAULT 'México',
  `principal` int(1) DEFAULT '0' COMMENT '1 - principal, 0 - normal',
  `id_cliente` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '1 - activo, 33 - borrado',
  `fecha_creacion` datetime NOT NULL,
  `telefono` varchar(12) NOT NULL,
  PRIMARY KEY (`id_direccion`),
  UNIQUE KEY `id_direccion_UNIQUE` (`id_direccion`),
  KEY `fk_DireccionesPorCliente_Clientes_idx` (`id_cliente`),
  CONSTRAINT `fk_DireccionesPorCliente_Clientes` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla DisenoProductos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `DisenoProductos`;

CREATE TABLE `DisenoProductos` (
  `id_diseno` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `color_hex` text,
  `color_title` text,
  `price` text,
  `front` text,
  `back` text,
  `left` text,
  `right` text,
  `area` text,
  `params` text,
  PRIMARY KEY (`id_diseno`),
  KEY `id_producto` (`id_producto`),
  CONSTRAINT `id_producto` FOREIGN KEY (`id_producto`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `DisenoProductos` WRITE;
/*!40000 ALTER TABLE `DisenoProductos` DISABLE KEYS */;

INSERT INTO `DisenoProductos` (`id_diseno`, `id_producto`, `color_hex`, `color_title`, `price`, `front`, `back`, `left`, `right`, `area`, `params`)
VALUES
	(1,1,'[\"FFFFFF\"]','[\"Blanco con negro\"]',NULL,'[\"\"]','[\"\"]','[\"\"]','[\"\"]','{\"front\":\"{\'width\':204,\'height\':283,\'left\':\'135px\',\'top\':\'90px\',\'radius\':\'0px\',\'zIndex\':\'\'}\",\"back\":\"{\'width\':204,\'height\':283,\'left\':\'135px\',\'top\':\'90px\',\'radius\':\'0px\',\'zIndex\':\'\'}\",\"left\":\"{\'width\':204,\'height\':283,\'left\':\'135px\',\'top\':\'90px\',\'radius\':\'0px\',\'zIndex\':\'\'}\",\"right\":\"{\'width\':204,\'height\':283,\'left\':\'135px\',\'top\':\'90px\',\'radius\':\'0px\',\'zIndex\':\'\'}\"}','{\"front\":\"{\'width\':\'21\',\'height\':\'29\',\'lockW\':true,\'lockH\':true,\'setbg\':false,\'shape\':\'square\',\'shapeVal\':0}\",\"back\":\"{\'width\':\'21\',\'height\':\'29\',\'lockW\':true,\'lockH\':true,\'setbg\':false,\'shape\':\'square\',\'shapeVal\':0}\",\"left\":\"{\'width\':\'21\',\'height\':\'29\',\'lockW\':true,\'lockH\':true,\'setbg\':false,\'shape\':\'square\',\'shapeVal\':0}\",\"right\":\"{\'width\':\'21\',\'height\':\'29\',\'lockW\':true,\'lockH\':true,\'setbg\':false,\'shape\':\'square\',\'shapeVal\':0}\"}');

/*!40000 ALTER TABLE `DisenoProductos` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla Enhance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Enhance`;

CREATE TABLE `Enhance` (
  `id_enhance` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `type` varchar(50) NOT NULL COMMENT 'social | lucrativa',
  `id_producto` int(11) DEFAULT NULL,
  `design` text,
  `sold` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double(12,2) DEFAULT NULL,
  `front_image` varchar(300) DEFAULT NULL,
  `back_image` varchar(300) DEFAULT NULL,
  `right_image` varchar(300) DEFAULT NULL,
  `left_image` varchar(300) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_color` int(11) DEFAULT NULL,
  `estatus` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_enhance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla FotografiasPorProducto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `FotografiasPorProducto`;

CREATE TABLE `FotografiasPorProducto` (
  `id_fotografia` int(11) NOT NULL AUTO_INCREMENT,
  `fotografia_original` varchar(200) DEFAULT NULL,
  `fotografia_grande` varchar(200) DEFAULT NULL,
  `fotografia_mediana` varchar(200) DEFAULT NULL,
  `fotografia_chica` varchar(200) DEFAULT NULL,
  `fotografia_icono` varchar(200) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '0 - inactivo, 1 - activo, 33 - borrado',
  `principal` int(11) DEFAULT '0' COMMENT '0 - no es principal, 1 - es principal',
  `id_color` int(11) NOT NULL,
  PRIMARY KEY (`id_fotografia`),
  UNIQUE KEY `id_color_UNIQUE` (`id_fotografia`),
  KEY `fk_FotografiasPorProducto_ColoresPorProducto1_idx` (`id_color`),
  CONSTRAINT `fk_FotografiasPorProducto_ColoresPorProducto1` FOREIGN KEY (`id_color`) REFERENCES `ColoresPorProducto` (`id_color`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `FotografiasPorProducto` WRITE;
/*!40000 ALTER TABLE `FotografiasPorProducto` DISABLE KEYS */;

INSERT INTO `FotografiasPorProducto` (`id_fotografia`, `fotografia_original`, `fotografia_grande`, `fotografia_mediana`, `fotografia_chica`, `fotografia_icono`, `estatus`, `principal`, `id_color`)
VALUES
	(1,'playera-deportiva_1212_blanco-con-negro.jpg','1800_playera-deportiva_1212_blanco-con-negro.jpg','900_playera-deportiva_1212_blanco-con-negro.jpg','450_playera-deportiva_1212_blanco-con-negro.jpg','200_playera-deportiva_1212_blanco-con-negro.jpg',1,1,1);

/*!40000 ALTER TABLE `FotografiasPorProducto` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla fuentes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fuentes`;

CREATE TABLE `fuentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'google',
  `subtitle` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `path` varchar(250) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla ListasProductos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ListasProductos`;

CREATE TABLE `ListasProductos` (
  `id_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `fecha_agregado` datetime DEFAULT NULL,
  PRIMARY KEY (`id_producto`,`id_cliente`),
  KEY `fk_ListasProductos_Clientes1_idx` (`id_cliente`),
  CONSTRAINT `fk_ListasProductos_CatalogoProductos1` FOREIGN KEY (`id_producto`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ListasProductos_Clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Marcas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Marcas`;

CREATE TABLE `Marcas` (
  `id_marca` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_marca` varchar(100) NOT NULL,
  `nombre_marca_slug` varchar(100) NOT NULL,
  `logotipo_original` varchar(200) DEFAULT NULL,
  `logotipo_grande` varchar(200) DEFAULT NULL,
  `logotipo_chico` varchar(200) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '1 - activo, 0 - inactivo, 33 - borrado',
  PRIMARY KEY (`id_marca`),
  UNIQUE KEY `id_marca_UNIQUE` (`id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `Marcas` WRITE;
/*!40000 ALTER TABLE `Marcas` DISABLE KEYS */;

INSERT INTO `Marcas` (`id_marca`, `nombre_marca`, `nombre_marca_slug`, `logotipo_original`, `logotipo_grande`, `logotipo_chico`, `estatus`)
VALUES
	(1,'Optima','optima',NULL,NULL,NULL,1);

/*!40000 ALTER TABLE `Marcas` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla Ofertas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Ofertas`;

CREATE TABLE `Ofertas` (
  `id_oferta` int(11) NOT NULL AUTO_INCREMENT,
  `imagen_original` varchar(200) NOT NULL,
  `imagen_large` varchar(200) DEFAULT NULL,
  `imagen_medium` varchar(200) DEFAULT NULL,
  `imagen_small` varchar(200) DEFAULT NULL,
  `imagen_icono` varchar(200) DEFAULT NULL,
  `fecha_subido` datetime DEFAULT NULL,
  `url_oferta` varchar(1000) DEFAULT NULL,
  `estatus` int(11) DEFAULT '1' COMMENT '1 - activo, 0 - inactivo, 33 - borrado',
  PRIMARY KEY (`id_oferta`),
  UNIQUE KEY `id_slide_UNIQUE` (`id_oferta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Pedidos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Pedidos`;

CREATE TABLE `Pedidos` (
  `id_pedido` bigint(20) NOT NULL AUTO_INCREMENT,
  `fecha_creacion` datetime NOT NULL,
  `estatus_pedido` varchar(200) NOT NULL DEFAULT 'En Proceso',
  `codigo_rastreo` varchar(100) DEFAULT NULL,
  `metodo_pago` varchar(50) DEFAULT NULL,
  `id_pago` varchar(200) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `estatus_pago` varchar(100) DEFAULT 'pending',
  `referencia_pago` varchar(200) DEFAULT NULL,
  `subtotal` double(12,2) NOT NULL,
  `iva` double(12,2) NOT NULL,
  `total` double(12,2) NOT NULL,
  `costo_envio` double(12,2) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `oxxo_codigo_barras` varchar(1000) DEFAULT NULL,
  `oxxo_fecha_vencimiento` datetime DEFAULT NULL,
  `id_cupon` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  UNIQUE KEY `id_pedido_UNIQUE` (`id_pedido`),
  KEY `fk_Pedidos_DireccionesPorCliente1_idx` (`id_direccion`),
  KEY `fk_Pedidos_Clientes1_idx` (`id_cliente`),
  CONSTRAINT `fk_Pedidos_Clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pedidos_DireccionesPorCliente1` FOREIGN KEY (`id_direccion`) REFERENCES `DireccionesPorCliente` (`id_direccion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla PreferenciasCliente
# ------------------------------------------------------------

DROP TABLE IF EXISTS `PreferenciasCliente`;

CREATE TABLE `PreferenciasCliente` (
  `id_preferencia` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `veces_abierto` bigint(20) NOT NULL DEFAULT '0',
  `ultima_vez_visto` datetime DEFAULT NULL,
  PRIMARY KEY (`id_preferencia`,`id_cliente`,`id_producto`),
  UNIQUE KEY `id_preferencia_UNIQUE` (`id_preferencia`),
  KEY `fk_PreferenciasCliente_Clientes1_idx` (`id_cliente`),
  KEY `fk_PreferenciasCliente_CatalogoProductos1_idx` (`id_producto`),
  CONSTRAINT `fk_PreferenciasCliente_CatalogoProductos1` FOREIGN KEY (`id_producto`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_PreferenciasCliente_Clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `Clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla ProductosDevueltos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ProductosDevueltos`;

CREATE TABLE `ProductosDevueltos` (
  `id_devolucion` int(11) NOT NULL,
  `id_ppp` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '0' COMMENT '0 - inactivo, 1 - aprobado, 33 - cancelado',
  PRIMARY KEY (`id_devolucion`,`id_ppp`),
  KEY `fk_ProductosDevueltos_ProductosPorPedido1_idx` (`id_ppp`),
  CONSTRAINT `fk_ProductosDevueltos_Devoluciones1` FOREIGN KEY (`id_devolucion`) REFERENCES `Devoluciones` (`id_devolucion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductosDevueltos_ProductosPorPedido1` FOREIGN KEY (`id_ppp`) REFERENCES `ProductosPorPedido` (`id_ppp`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla ProductosPorPedido
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ProductosPorPedido`;

CREATE TABLE `ProductosPorPedido` (
  `id_ppp` int(11) NOT NULL AUTO_INCREMENT,
  `id_sku` int(11) NOT NULL,
  `precio_producto` double(12,2) DEFAULT NULL,
  `descuento_especifico` double(12,2) DEFAULT NULL,
  `cantidad_producto` int(11) DEFAULT NULL,
  `aplica_devolucion` int(11) DEFAULT NULL,
  `envio_gratis` int(11) DEFAULT NULL,
  `id_pedido` bigint(20) NOT NULL,
  `diseno` text,
  `id_enhance` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ppp`),
  UNIQUE KEY `id_ppp_UNIQUE` (`id_ppp`),
  KEY `fk_ProductosPorPedido_CatalogoSkuPorProducto1_idx` (`id_sku`),
  KEY `fk_ProductosPorPedido_Pedidos1_idx` (`id_pedido`),
  CONSTRAINT `fk_ProductosPorPedido_CatalogoSkuPorProducto1` FOREIGN KEY (`id_sku`) REFERENCES `CatalogoSkuPorProducto` (`id_sku`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductosPorPedido_Pedidos1` FOREIGN KEY (`id_pedido`) REFERENCES `Pedidos` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla ProductosRelacionados
# ------------------------------------------------------------

DROP TABLE IF EXISTS `ProductosRelacionados`;

CREATE TABLE `ProductosRelacionados` (
  `id_pr` int(11) NOT NULL,
  `id_producto_relacionado` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_pr`),
  KEY `fk_ProductosRelacionados_CatalogoProductos1_idx` (`id_producto`),
  KEY `fk_ProductosRelacionados_CatalogoProductos2_idx` (`id_producto_relacionado`),
  CONSTRAINT `fk_ProductosRelacionados_CatalogoProductos1` FOREIGN KEY (`id_producto`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ProductosRelacionados_CatalogoProductos2` FOREIGN KEY (`id_producto_relacionado`) REFERENCES `CatalogoProductos` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Sesiones_carrito
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Sesiones_carrito`;

CREATE TABLE `Sesiones_carrito` (
  `id_carrito` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `json` text,
  PRIMARY KEY (`id_carrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla Slider
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Slider`;

CREATE TABLE `Slider` (
  `id_slide` int(11) NOT NULL AUTO_INCREMENT,
  `imagen_original` varchar(200) NOT NULL,
  `imagen_xlarge` varchar(200) DEFAULT NULL,
  `imagen_large` varchar(200) DEFAULT NULL,
  `imagen_medium` varchar(200) DEFAULT NULL,
  `imagen_small` varchar(200) DEFAULT NULL,
  `imagen_icono` varchar(200) DEFAULT NULL,
  `fecha_subido` datetime DEFAULT NULL,
  `url_slide` varchar(1000) DEFAULT NULL,
  `estatus` int(11) DEFAULT '1' COMMENT '1 - activo, 0 - inactivo, 33 - borrado',
  PRIMARY KEY (`id_slide`),
  UNIQUE KEY `id_slide_UNIQUE` (`id_slide`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla TipoPerteneceACategoria
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TipoPerteneceACategoria`;

CREATE TABLE `TipoPerteneceACategoria` (
  `id_tipo` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo`,`id_categoria`),
  KEY `fk_TipoPerteneceACategoria_Categorias1_idx` (`id_categoria`),
  CONSTRAINT `fk_TipoPerteneceACategoria_Categorias1` FOREIGN KEY (`id_categoria`) REFERENCES `Categorias` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_TipoPerteneceACategoria_TiposDeProducto1` FOREIGN KEY (`id_tipo`) REFERENCES `TiposDeProducto` (`id_tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Volcado de tabla TiposDeProducto
# ------------------------------------------------------------

DROP TABLE IF EXISTS `TiposDeProducto`;

CREATE TABLE `TiposDeProducto` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_tipo` varchar(100) DEFAULT NULL,
  `nombre_tipo_slug` varchar(100) DEFAULT NULL,
  `caracteristicas_tipo` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT '1' COMMENT '0 - inactivo, 1 - activo, 33 - borrado',
  PRIMARY KEY (`id_tipo`),
  UNIQUE KEY `id_tipo_UNIQUE` (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `TiposDeProducto` WRITE;
/*!40000 ALTER TABLE `TiposDeProducto` DISABLE KEYS */;

INSERT INTO `TiposDeProducto` (`id_tipo`, `nombre_tipo`, `nombre_tipo_slug`, `caracteristicas_tipo`, `estatus`)
VALUES
	(4,'Playera','playera','{\"talla\":{\"titulo\":\"Talla\",\"opciones\":[\"XS\",\"S\",\"M\",\"L\",\"XL\"]}}',1);

/*!40000 ALTER TABLE `TiposDeProducto` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
