-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 19-10-2012 a las 17:10:27
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `ssrp1`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `contrato`
-- 

CREATE TABLE `contrato` (
  `id_con` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `date_ent` date NOT NULL,
  `date_end` date NOT NULL,
  `f_status` int(1) NOT NULL,
  `name_con` varchar(1000) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_con`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `contrato`
-- 

INSERT INTO `contrato` VALUES (1, 1, '2012-10-01', '0000-00-00', 1, '');
INSERT INTO `contrato` VALUES (2, 3, '2012-02-09', '0000-00-00', 1, '');
