-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 19-10-2012 a las 17:11:03
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `ssrp1`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permanente`
-- 

CREATE TABLE `permanente` (
  `id_per` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `date_ent` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id_per`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `permanente`
-- 

INSERT INTO `permanente` VALUES (1, 2, '2012-10-01', 1);
INSERT INTO `permanente` VALUES (2, 4, '2010-03-01', 1);
