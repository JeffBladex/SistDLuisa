-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3366
-- Tiempo de generación: 20-02-2020 a las 03:42:31
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_ventas_luisa_car`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_precio_compra` (IN `n_cantidad` INT, IN `n_precio_venta` DECIMAL(8,2), IN `codigo_compra` INT)  BEGIN
    	DECLARE nueva_existencia int;
        DECLARE nuevo_total decimal(8,2);
        DECLARE nuevo_precio_venta decimal(8,2);
        
        DECLARE cant_actual int;
        DECLARE pre_venta_actual decimal(8,2);
        
        DECLARE actual_existencia int;
        DECLARE actual_precio_venta decimal(8,2);
        
        DECLARE fecha_mod datetime;
        
        SELECT precio_venta, existencia INTO actual_precio_venta, actual_existencia
        FROM compras where idcompras = codigo_compra;
        SET nueva_existencia = actual_existencia + n_cantidad;
        SET nuevo_total = (actual_existencia * actual_precio_venta) + (n_cantidad * n_precio_venta);
        SET nuevo_precio_venta = n_precio_venta;
        
        SET fecha_mod = now();
        
        UPDATE compras SET existencia = nueva_existencia,
        					precio_venta = nuevo_precio_venta,
                            fecha_add = fecha_mod
        WHERE idcompras = codigo_compra;
        
        SELECT nueva_existencia, nuevo_precio_venta, fecha_mod;
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_detalle_ventas_temp` (IN `idcompras` INT, IN `idarticulo` INT, IN `codigo_articulo` VARCHAR(50), IN `cantidad` INT, IN `precio_pagar` DECIMAL(8,2), IN `token_user` VARCHAR(50), IN `secuencia` INT)  BEGIN
            DECLARE descripcion_art varchar(150);
            SELECT descripcion INTO descripcion_art FROM articulo as art where art.idarticulo = idarticulo;
            
            INSERT INTO detalle_ventas_temp(idcompras,idarticulo,secuencia,codigo_articulo,descripcion,cantidad,precio_venta,token_user)
            VALUES(idcompras,idarticulo,secuencia,codigo_articulo,UPPER(descripcion_art),cantidad,precio_pagar,token_user);
           
        END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `anular_factura` (IN `nrofactura` INT)  BEGIN
    	DECLARE existe_factura int;
        DECLARE registros int;
        DECLARE anu int;
        
        DECLARE cod_producto int;
        DECLARE cant_producto int;
        DECLARE existencia_actual int;
        DECLARE nueva_existencia int;
        
        SET existe_factura = (SELECT COUNT(*) FROM factura WHERE nrofactura = nrofactura AND estatus=1);
       IF existe_factura > 0 THEN
       		CREATE TEMPORARY TABLE tbl_temp_fact(
            	id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cod_prod bigint,
                cant_prod int
            );
            
            SET anu = 1;
            
            SET registros = (SELECT COUNT(*) FROM detalle_factura AS df WHERE df.nrofactura = nrofactura);
            
            IF registros > 0 THEN
            	INSERT INTO tbl_temp_fact(cod_prod, cant_prod)
                SELECT compras.idcompras, df.cantidad
                FROM detalle_factura df join compras as compras on compras.idarticulo = df.idarticulo
                WHERE df.nrofactura = nrofactura;
                
                WHILE anu <= registros DO
                	SELECT cod_prod, cant_prod into cod_producto, cant_producto FROM tbl_temp_fact WHERE id = anu;

                SELECT existencia into existencia_actual FROM compras as compras join articulo as articulo on compras.idarticulo = articulo.idarticulo
                WHERE compras.idcompras = cod_producto;
                
                SET nueva_existencia = existencia_actual + cant_producto;
                
                UPDATE compras as compras SET existencia = nueva_existencia WHERE compras.idcompras = cod_producto;
                
                SET anu = anu + 1;
                
                END WHILE;
                
                UPDATE factura AS f set estatus = 0 where f.nrofactura = 				 nrofactura;
                DROP TABLE tbl_temp_fact;
                
            SELECT * FROM factura AS f where f.nrofactura = nrofactura;
                
            END IF;
            
       ELSE
       	SELECT 0 factura;
       END IF;
    
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_detalle_temp` (IN `correlativo` INT, IN `token` VARCHAR(50))  BEGIN
    	DELETE FROM detalle_ventas_temp WHERE correlativo = correlativo;
        
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `procesar_venta` (IN `idusuario` INT, IN `idcliente` INT, IN `token_secuencia` INT)  BEGIN
            DECLARE factura int;
            DECLARE registros int;
            DECLARE total decimal(8,2);
            
            DECLARE nueva_existencia int;
            DECLARE existencia_actual int;
            
            DECLARE tmp_cod_producto int;
            DECLARE tmp_cant_producto int;
            
            DECLARE p_base decimal(8,2);
            DECLARE pwiva decimal(8,2);
            
            DECLARE a int;
            set a=1;
            
            CREATE TEMPORARY TABLE tbl_tmp_tokensecuencia(
            	id bigint not null AUTO_INCREMENT PRIMARY KEY,
                cod_producto bigint,
                cant_producto int
            );
            
            SET registros  = (SELECT COUNT(*) FROM detalle_ventas_temp
                              WHERE secuencia= token_secuencia);
                              
            IF registros > 0 THEN
            	INSERT INTO tbl_tmp_tokensecuencia(cod_producto, cant_producto)
                SELECT idcompras, cantidad
                FROM detalle_ventas_temp
                WHERE secuencia = token_secuencia;
                
                INSERT INTO factura(idusuario, idcliente) VALUES(idusuario, idcliente);
                SET factura = LAST_INSERT_ID();
             
                INSERT INTO detalle_factura(nrofactura, idarticulo, cantidad, precio_venta, precio_total)
                SELECT (factura) AS nrofactura, dtalle_vta_tmp.idarticulo, dtalle_vta_tmp.cantidad, dtalle_vta_tmp.precio_venta, (dtalle_vta_tmp.cantidad * dtalle_vta_tmp.precio_venta) as precio_total
                FROM detalle_ventas_temp as dtalle_vta_tmp
                WHERE secuencia= token_secuencia;
                
                WHILE a <= registros DO
                	SELECT cod_producto, cant_producto
                    INTO tmp_cod_producto, tmp_cant_producto
                    FROM tbl_tmp_tokensecuencia
                    WHERE id = a;
                    
                    SELECT existencia  INTO existencia_actual
                    FROM compras where idcompras = tmp_cod_producto;
                    
                    SET nueva_existencia = existencia_actual - tmp_cant_producto;
                    UPDATE compras set existencia = nueva_existencia where idcompras = tmp_cod_producto;
                    
                    SET a=a+1;
                    
                END WHILE;
                
                SET p_base = (SELECT SUM(cantidad * precio_venta) as pbase FROM detalle_ventas_temp 
                             WHERE secuencia = token_secuencia);
                
                SET pwiva = (SELECT SUM(cantidad * precio_venta*0.12) as iva FROM detalle_ventas_temp 
                             WHERE secuencia = token_secuencia);
                             
                SET total = (SELECT SUM(cantidad * precio_venta*1.12) from detalle_ventas_temp
                WHERE secuencia = token_secuencia);
                
                UPDATE factura set 
                pbase = p_base, 
                piva = pwiva,
                total_factura = total WHERE nrofactura = factura;    
                
                DELETE FROM detalle_ventas_temp WHERE secuencia = token_secuencia;
                TRUNCATE TABLE tbl_tmp_tokensecuencia;
                SELECT * FROM factura where nrofactura = factura;
 
                
            ELSE
            	SELECT 0;
            
            END IF;
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulo`
--

CREATE TABLE `articulo` (
  `idarticulo` int(11) NOT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `codigo` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estatus` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_add` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `articulo`
--

INSERT INTO `articulo` (`idarticulo`, `idcategoria`, `codigo`, `nombre`, `descripcion`, `estatus`, `fecha_add`) VALUES
(26, 9, 'coc-001', 'Coca cola', 'Coca cola', '1', '2020-02-17 16:00:32'),
(27, 11, 'dvalle001', 'Jugo Del Valle', 'Jugo Del Valle', '1', '2020-02-17 16:01:31'),
(28, 10, 'dor-001', 'Doritos Orginales', 'Doritos Orginales', '1', '2020-02-17 16:05:55'),
(29, 10, 'pap-art001', 'Papas Artesanales', 'Papas Artesanales', '1', '2020-02-17 16:08:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `descripcion` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` char(1) COLLATE utf8_spanish2_ci DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombre`, `descripcion`, `fecha_add`, `estatus`) VALUES
(9, 'Colas', 'Colas', '2020-02-17 15:59:37', '1'),
(10, 'Snacks', 'Snacks', '2020-02-17 15:59:47', '1'),
(11, 'Jugos', 'Jugos', '2020-02-17 16:00:49', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `tipo_documento` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `numero_documento` varchar(13) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `estatus` char(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `tipo_documento`, `numero_documento`, `nombre`, `direccion`, `telefono`, `email`, `fecha_add`, `idusuario`, `estatus`) VALUES
(1, '0', 'CF', 'CLIENTE FINAL', NULL, NULL, NULL, '2020-02-05 15:22:41', 1, '1'),
(3, 'Cédula', '1303753618', 'Pablo Nieto2', 'Portoviejo2', '2568999', 'pablo-nieto2@gmail.com', '2020-01-21 21:47:54', 1, '1'),
(4, 'Cédula', '1706172648', 'Narcisa Del Pilar2', 'Manabi2', '2857422', 'narcisa-del-pilar2@gmail.com', '2020-01-21 21:49:20', 1, '1'),
(9, 'Ruc', '0100967652', 'Carlos Enrique Abril', 'Azuay', '2869541', '', '2020-01-21 21:59:55', 1, '1'),
(10, 'Cédula', '1704997012', 'Sonia Acevedo', 'Pichincha', '2451653', '', '2020-01-21 22:14:07', 1, '1'),
(11, 'Cédula', '1714818292', 'David Acosta', 'Pichincha', '2117563', '', '2020-01-21 22:16:36', 1, '1'),
(12, 'Cédula', '1713627071', 'Martin Acurio', 'Pichincha', '2748596', '', '2020-01-21 22:17:34', 1, '1'),
(13, 'Cédula', '', 'Eugenia Moyon', 'Azuay', '2156478', '', '2020-01-21 22:19:04', 1, '0'),
(15, 'Cédula', '', 'Rebeca Ferbuzon', 'dominos city', '2415698', '', '2020-01-21 23:02:15', 1, '1'),
(16, 'Cédula', '8989889', 'Maricarmen Del Pozo', 'Guayaquil', '464546', NULL, '2020-01-29 23:17:19', 1, '1'),
(17, 'Cédula', '7777889', 'Luipita Ferrer', 'Guayaquil', '245857', NULL, '2020-01-29 23:22:02', 1, '1'),
(18, 'Ruc', '8555555', 'Elena De Troya', 'Quito', '445585', NULL, '2020-01-29 23:22:40', 1, '1'),
(19, 'Cédula', '8625426691', 'Juanito Rodriguez', 'Guayaquil', '1234', NULL, '2020-01-29 23:40:10', 1, '1'),
(20, 'Cédula', '55556666', 'Marian Campos', 'Guayaquil', '5588662', NULL, '2020-01-30 11:54:17', 1, '1'),
(21, 'Cédula', '229082763', 'Juan Carlos Michelena', 'guayaquil', '1234', NULL, '2020-02-05 16:30:15', 1, '1'),
(22, 'Cédula', '0912344123', 'Juan Piguave', 'guayaquil', '1234', NULL, '2020-02-06 15:56:24', 1, '1'),
(23, 'Cédula', '1908726512', 'Ricardo Milos', 'Guayaquil', '1234', NULL, '2020-02-07 00:18:19', 1, '1'),
(24, 'Cédula', '1298106312', 'Zoria Campos', 'Guayaquil', '12234', NULL, '2020-02-07 01:22:57', 1, '1'),
(25, 'Cédula', '0911887253', 'Miguelito Zambrano', 'quito', '123456', NULL, '2020-02-07 11:24:14', 1, '1'),
(26, 'Cédula', '12345567', 'juanito', 'casa de juanito', '1234', 'juanito@gmail.com', '2020-02-16 20:18:54', 17, '0'),
(27, 'Cédula', '091246236', 'jdioshid', 'gsdkjbsjk', '23242', NULL, '2020-02-16 20:30:24', 17, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `idcompras` int(11) NOT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `serie_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tipo_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `num_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `existencia` int(11) NOT NULL,
  `precio_compra` decimal(8,2) DEFAULT NULL,
  `precio_venta` decimal(8,2) DEFAULT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` char(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '1',
  `idarticulo` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`idcompras`, `idproveedor`, `serie_comprobante`, `tipo_comprobante`, `num_comprobante`, `existencia`, `precio_compra`, `precio_venta`, `fecha_add`, `estatus`, `idarticulo`, `idusuario`) VALUES
(65, 7, '001', 'FACTURA', '20208976', 10, '20.00', '23.50', '2020-02-17 16:04:32', '1', 26, 17),
(66, 7, '002', 'FACTURA', '2090872', 8, '15.00', '18.00', '2020-02-18 16:29:43', '1', 27, 17),
(67, 9, '003', 'FACTURA', '20908643', 11, '22.00', '25.50', '2020-02-17 16:07:57', '1', 28, 17),
(68, 10, '002', 'FACTURA', '115683839', 17, '26.40', '31.00', '2020-02-17 16:29:00', '1', 29, 17);

--
-- Disparadores `compras`
--
DELIMITER $$
CREATE TRIGGER `actualizar_existencia_producto` AFTER INSERT ON `compras` FOR EACH ROW BEGIN
        	INSERT INTO detalle_compra(idcompras, idarticulo, cantidad, precio_compra, precio_venta,
                        idusuario)
            VALUES(new.idcompras, new.idarticulo, new.existencia, new.precio_compra, 		new.precio_venta, new.idusuario);
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `idconfiguracion` int(11) NOT NULL,
  `numero_identificacion` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `razon_social` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono1` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono2` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish2_ci NOT NULL,
  `iva` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`idconfiguracion`, `numero_identificacion`, `nombre`, `razon_social`, `telefono1`, `telefono2`, `email`, `direccion`, `iva`) VALUES
(1, '1234', 'Luisa Astudillo', 'Accesorios D\' Astu S.A', '1234', '1234', 'lastudillo5@hotmail.com', 'Ayacucho', '12.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `iddetalle_compra` int(11) NOT NULL,
  `idcompras` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` decimal(8,2) DEFAULT NULL,
  `precio_venta` decimal(8,2) DEFAULT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`iddetalle_compra`, `idcompras`, `idarticulo`, `cantidad`, `precio_compra`, `precio_venta`, `idusuario`) VALUES
(55, 65, 26, 11, '20.00', '23.50', 17),
(56, 66, 27, 9, '15.00', '18.00', 17),
(57, 67, 28, 12, '22.00', '25.50', 17),
(58, 68, 29, 13, '26.40', '28.40', 17),
(59, 68, 29, 2, '26.40', '28.50', 17),
(60, 68, 29, 1, '26.40', '30.00', 17),
(61, 68, 29, 1, '26.40', '31.00', 17),
(62, 66, 27, 1, '15.00', '18.00', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `correlativo` int(11) NOT NULL,
  `nrofactura` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `precio_venta` decimal(8,2) DEFAULT NULL,
  `precio_total` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`correlativo`, `nrofactura`, `idarticulo`, `cantidad`, `precio_venta`, `precio_total`) VALUES
(20, 161, 27, '2', '18.50', '37.00'),
(21, 161, 28, '1', '19.00', '19.00'),
(22, 161, 26, '1', '23.50', '23.50'),
(23, 162, 29, '2', '25.00', '50.00'),
(24, 162, 28, '1', '25.50', '25.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `iddetalle_venta` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_venta` decimal(8,2) DEFAULT NULL,
  `descuento` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas_temp`
--

CREATE TABLE `detalle_ventas_temp` (
  `correlativo` int(11) NOT NULL,
  `token_user` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `secuencia` int(11) NOT NULL,
  `codigo_articulo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `idcompras` int(11) NOT NULL,
  `idarticulo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_venta` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_ventas_temp`
--

INSERT INTO `detalle_ventas_temp` (`correlativo`, `token_user`, `secuencia`, `codigo_articulo`, `descripcion`, `idcompras`, `idarticulo`, `cantidad`, `precio_venta`) VALUES
(98, '70efdf2ec9b086079795c442636b55fb', 0, 'dor-001', 'DORITOS ORGINALES', 67, 28, 1, '25.50'),
(99, '70efdf2ec9b086079795c442636b55fb', 0, 'coc-001', 'COCA COLA', 65, 26, 2, '21.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `nrofactura` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `total_factura` decimal(10,2) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1,
  `pbase` decimal(8,2) DEFAULT NULL,
  `piva` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`nrofactura`, `idcliente`, `idusuario`, `total_factura`, `fecha`, `estatus`, `pbase`, `piva`) VALUES
(161, 1, 17, '89.04', '2020-02-17 17:20:40', 1, '79.50', '9.54'),
(162, 1, 17, '84.56', '2020-02-17 17:56:06', 0, '75.50', '9.06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idproveedor` int(11) NOT NULL,
  `cod_proveedor` varchar(30) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_add` datetime NOT NULL DEFAULT current_timestamp(),
  `idusuario` int(11) NOT NULL,
  `estatus` char(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idproveedor`, `cod_proveedor`, `nombre`, `telefono`, `direccion`, `email`, `fecha_add`, `idusuario`, `estatus`) VALUES
(7, 'coca01', 'Coca company', '1234', 'coca cola s.a', 'coca-cola@gmail.com', '2020-02-17 15:57:35', 17, '1'),
(8, 'sp001', 'Sprite', '1234', 'Sprite s.a', 'sprite@hotmail.com', '2020-02-17 15:58:02', 17, '1'),
(9, 'dor001', 'Doritos', '12345', 'Doritos s.a', 'doritos@gmail.com', '2020-02-17 15:58:26', 17, '1'),
(10, 'pap-art001', 'Papas Artesanales', '12345', 'Papas Artesanales S.A', 'papar@outlook.com', '2020-02-17 15:59:08', 17, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_compras`
--

CREATE TABLE `registro_compras` (
  `idRegistroCompras` int(11) NOT NULL,
  `idproveedor` int(11) NOT NULL,
  `serie_comprobante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo_comprobante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `num_comprobante` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `existencia` int(11) NOT NULL,
  `precio_compra` decimal(8,2) DEFAULT NULL,
  `fecha_add` datetime DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1,
  `idarticulo` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `registro_compras`
--

INSERT INTO `registro_compras` (`idRegistroCompras`, `idproveedor`, `serie_comprobante`, `tipo_comprobante`, `num_comprobante`, `existencia`, `precio_compra`, `fecha_add`, `estatus`, `idarticulo`, `idusuario`) VALUES
(8, 7, '001', 'FACTURA', '20208976', 11, '20.00', '2020-02-17 16:02:15', 1, 26, 17),
(9, 7, '001', 'FACTURA', '20208976', 11, '20.00', '2020-02-17 16:02:41', 0, 26, 17),
(10, 7, '002', 'FACTURA', '2090872', 9, '15.00', '2020-02-17 16:02:58', 1, 27, 17),
(11, 9, '003', 'FACTURA', '20908643', 12, '22.00', '2020-02-17 16:06:51', 1, 28, 17),
(12, 10, '002', 'FACTURA', '115683839', 13, '26.00', '2020-02-17 16:08:59', 0, 29, 17),
(13, 10, '003', 'FACTURA', '4455582', 13, '26.40', '2020-02-17 16:11:54', 1, 29, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `rol`) VALUES
(1, 'Admin'),
(2, 'Asistente'),
(3, 'Supervisor'),
(4, 'Vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `estatus` char(1) COLLATE utf8_spanish2_ci NOT NULL DEFAULT '1',
  `idrol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `usuario`, `email`, `password`, `estatus`, `idrol`) VALUES
(1, 'Yugimaster', 'yugimaster', 'yugimaster@hotmail.com', '12345', '1', 1),
(3, 'Genaro Tomala', 'genaro tomala', 'genaro-tomala@gmail.com', '12345', '1', 3),
(5, 'KArol G', 'karolG', 'karolg@hotmail.com', '12345', '0', 3),
(6, 'Sandra Rivadeneira', 'sandra-rivadeneira', 'sandra-rivadeneira@gmail.com', '12345', '0', 1),
(7, 'Carlos Lino', 'carlos-lino', 'carlos-lino@hotmail.com', '12345', '1', 3),
(8, 'Ricardo Milos', 'ricardo-milos', 'ricardo-milos@gmail.com', '12345', '1', 4),
(9, 'Sakura Intriago', 'sakura-intriago', 'sakura-intriago@hotmail.com', '12345', '1', 2),
(10, 'Luan Montoya2', 'luan-montoya2', 'luan-montoya2@gmail.com', '12345', '1', 4),
(11, 'Estefania Del Carmen', 'estefania-del-carmen', 'estefania-del-carmen@hotmail.com', '12345', '1', 3),
(12, 'Jeaime Riquelme', 'jaime-riquelme', 'jaime-riquelme@hotmail.com', '12345', '1', 1),
(13, 'Rebeca Campos', 'rebeca-campos', 'rebeca-campos@gmail.com', '12345', '1', 4),
(14, 'Carmen Salinas', 'carmen-salinas', 'carmen-salinas@gmail.com', '12345', '1', 2),
(15, 'Karla Lino', 'karla-lino', 'karla-lino@hotmail.com', '12345', '1', 3),
(16, 'Cecilia Ramos', 'cecilia-ramos', 'cecilia-ramos@outlook.com', '12345', '1', 3),
(17, 'Luisa Astudillo', 'lastudillo23', 'lastudillo5@hotmail.com', '1234', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idventas` int(11) NOT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `serie_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `numero_comprobante` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `iva` decimal(4,2) DEFAULT NULL,
  `total_venta` decimal(10,2) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD PRIMARY KEY (`idarticulo`),
  ADD KEY `fk_categoria_articulo` (`idcategoria`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `fk_usuario_cliente` (`idusuario`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`idcompras`),
  ADD KEY `fk_proveedor_compras` (`idproveedor`),
  ADD KEY `fk_usuario_compras` (`idusuario`),
  ADD KEY `fk_articulo_compras` (`idarticulo`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`idconfiguracion`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`iddetalle_compra`),
  ADD KEY `idarticulo` (`idarticulo`),
  ADD KEY `idcompras` (`idcompras`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `fk_factura_detalle_factura` (`nrofactura`),
  ADD KEY `fk_articulo_detalle_factura` (`idarticulo`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`iddetalle_venta`),
  ADD KEY `fk_venta_detalle_venta` (`idventa`),
  ADD KEY `fk_articulo_detalle_venta` (`idarticulo`);

--
-- Indices de la tabla `detalle_ventas_temp`
--
ALTER TABLE `detalle_ventas_temp`
  ADD PRIMARY KEY (`correlativo`),
  ADD KEY `fk_compras_detalle_ventas_temp` (`idcompras`),
  ADD KEY `fk_articulo_detalle_ventas_temp` (`idarticulo`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`nrofactura`),
  ADD KEY `fk_cliente_factura` (`idcliente`),
  ADD KEY `fk_usuario_factura` (`idusuario`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idproveedor`),
  ADD KEY `fk_usuario_proveedor` (`idusuario`);

--
-- Indices de la tabla `registro_compras`
--
ALTER TABLE `registro_compras`
  ADD PRIMARY KEY (`idRegistroCompras`),
  ADD KEY `fk_articulo_rcompra` (`idarticulo`),
  ADD KEY `fk_usuario_rcompra` (`idusuario`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idventas`),
  ADD KEY `fk_cliente_ventas` (`idcliente`),
  ADD KEY `fk_usuario_ventas` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `articulo`
  MODIFY `idarticulo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `idcompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `idconfiguracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `iddetalle_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas_temp`
--
ALTER TABLE `detalle_ventas_temp`
  MODIFY `correlativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `nrofactura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `registro_compras`
--
ALTER TABLE `registro_compras`
  MODIFY `idRegistroCompras` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idventas` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `articulo`
  ADD CONSTRAINT `fk_categoria_articulo` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_usuario_cliente` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_articulo_compras` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedor_compras` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_compras` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_articulo_detalle_compras` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_detalle_compra` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_detalle_compra` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD CONSTRAINT `fk_articulo_detalle_factura` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_detalle_factura` FOREIGN KEY (`nrofactura`) REFERENCES `factura` (`nrofactura`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `fk_articulo_detalle_venta` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_detalle_venta` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`idventas`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_ventas_temp`
--
ALTER TABLE `detalle_ventas_temp`
  ADD CONSTRAINT `fk_articulo_detalle_ventas_temp` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compras_detalle_ventas_temp` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`idcompras`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_cliente_factura` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_factura` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fk_usuario_proveedor` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro_compras`
--
ALTER TABLE `registro_compras`
  ADD CONSTRAINT `fk_articulo_rcompra` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`idarticulo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_rcompra` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_cliente_ventas` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_ventas` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
