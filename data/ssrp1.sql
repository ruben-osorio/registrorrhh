-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 06-10-2012 a las 20:27:57
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `ssrp1`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `adenda`
-- 

CREATE TABLE `adenda` (
  `id_ad` int(11) NOT NULL auto_increment,
  `id_cont` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY  (`id_ad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `adenda`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `baja`
-- 

CREATE TABLE `baja` (
  `id_baja` int(11) NOT NULL auto_increment,
  `id_per` int(11) NOT NULL,
  `date_pres` date NOT NULL,
  `date_efect` date NOT NULL,
  `reasone` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_baja`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `baja`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `capacitacion`
-- 

CREATE TABLE `capacitacion` (
  `id_cap` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `name_event` varchar(1000) NOT NULL,
  `type_cap` varchar(100) NOT NULL,
  `name_inst` varchar(500) NOT NULL,
  `place` varchar(100) NOT NULL,
  `num_hrs` int(10) NOT NULL,
  PRIMARY KEY  (`id_cap`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Volcar la base de datos para la tabla `capacitacion`
-- 

INSERT INTO `capacitacion` VALUES (1, 0, '2012-10-19', '2012-10-31', 'PHP EN DOS HORAS', 'EXTERNA', 'CONSULTORA JURIDICA', 'LA PAZ/BOLIVIA', 25);
INSERT INTO `capacitacion` VALUES (2, 0, '2012-10-13', '2012-10-12', 'JAVA', 'EXTERNA', 'JILIUS', 'LA PAZ/VENEZUELA', 24);
INSERT INTO `capacitacion` VALUES (3, 0, '2012-10-06', '2012-10-19', 'PHP', 'INTERNA', 'CONSULTORI JURIDICA', 'LA PAZ/BOLIVIA', 14);
INSERT INTO `capacitacion` VALUES (4, 0, '1943-06-12', '1990-06-12', 'HPHP2', 'INTERNA', 'UMSA', 'LA PAZ/VENEZUELA', 24);
INSERT INTO `capacitacion` VALUES (5, 0, '2012-09-04', '2012-09-05', 'JIN', 'INTERNA', 'A', 'SD', 2);
INSERT INTO `capacitacion` VALUES (6, 0, '2012-10-11', '2012-10-05', 'ASD', 'INTERNA', 'ASD', 'LA PAZ', 1);
INSERT INTO `capacitacion` VALUES (7, 0, '2012-10-03', '2012-10-12', 'ASD', 'INTERNA', 'ASD', 'ASD', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_con`
-- 

CREATE TABLE `cat_con` (
  `id_cat_con` int(11) NOT NULL auto_increment,
  `id_char_cont` int(11) NOT NULL,
  `cat` varchar(50) collate utf8_bin NOT NULL,
  `level` varchar(50) collate utf8_bin NOT NULL,
  `post_car` varchar(50) collate utf8_bin NOT NULL,
  `mod_ent` varchar(50) collate utf8_bin NOT NULL,
  `form_rec` varchar(50) collate utf8_bin NOT NULL,
  `jornal` varchar(50) collate utf8_bin NOT NULL,
  `sal_base` float(9,2) NOT NULL,
  PRIMARY KEY  (`id_cat_con`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `cat_con`
-- 

INSERT INTO `cat_con` VALUES (1, 0, 0x5355504552494f52, 0x4dc383c28158494d4153204155544f52494441444553, 0x5349, 0x434f4e56414c4944414349c383e2809c4e2044452050524f4345534f532053454c45434349c383e2809c4e, 0x494e564954414349c383e2809c4e2044495245435441, 0x5449454d504f20434f4d504c45544f, 123123.00);
INSERT INTO `cat_con` VALUES (2, 0, 0x5355504552494f52, 0x4dc383c28158494d4153204155544f52494441444553, 0x5349, 0x434f4e56414c4944414349c383e2809c4e2044452050524f4345534f532053454c45434349c383e2809c4e, 0x434f4e564f4341544f52412050c383c5a1424c4943412045585445524e41, 0x5449454d504f20434f4d504c45544f, 23.00);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cat_per`
-- 

CREATE TABLE `cat_per` (
  `id_cat_per` int(11) NOT NULL auto_increment,
  `id_char_per` int(11) NOT NULL,
  `cat` varchar(50) collate utf8_bin NOT NULL,
  `level` varchar(50) collate utf8_bin NOT NULL,
  `post_car` varchar(50) collate utf8_bin NOT NULL,
  `mod_ent` varchar(50) collate utf8_bin NOT NULL,
  `form_rec` varchar(50) collate utf8_bin NOT NULL,
  `jornal` varchar(50) collate utf8_bin NOT NULL,
  `sal_base` float(9,2) NOT NULL,
  PRIMARY KEY  (`id_cat_per`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `cat_per`
-- 

INSERT INTO `cat_per` VALUES (1, 0, 0x454a4543555449564f, 0x44495245435449564f53, 0x5349, 0x534552564943494f20434956494c, 0x434f4e564f4341544f5249412050c383c5a1424c49434120494e5445524e41, 0x4d4544494f205449454d504f, 900.00);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `char_con`
-- 

CREATE TABLE `char_con` (
  `id_char_con` int(11) NOT NULL auto_increment,
  `id_con` int(11) NOT NULL,
  `dir_g` varchar(500) collate utf8_bin NOT NULL,
  `unit` varchar(500) collate utf8_bin NOT NULL,
  `area` varchar(500) collate utf8_bin NOT NULL,
  `boss_is` varchar(200) collate utf8_bin NOT NULL,
  `boss_ij` varchar(200) collate utf8_bin NOT NULL,
  `charge` varchar(200) collate utf8_bin NOT NULL,
  `num_res_cont` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_char_con`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `char_con`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `char_per`
-- 

CREATE TABLE `char_per` (
  `id_char_per` int(11) NOT NULL auto_increment,
  `id_per` int(11) NOT NULL,
  `dir_g` varchar(500) collate utf8_bin NOT NULL,
  `unit` varchar(500) collate utf8_bin NOT NULL,
  `area` varchar(500) collate utf8_bin NOT NULL,
  `boss_is` varchar(200) collate utf8_bin NOT NULL,
  `boss_ij` varchar(200) collate utf8_bin NOT NULL,
  `charge` varchar(200) collate utf8_bin NOT NULL,
  `num_memo` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_char_per`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `char_per`
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `contrato`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `cta_banc`
-- 

CREATE TABLE `cta_banc` (
  `id_cta_banc` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `bank` varchar(200) NOT NULL,
  `type_ac` varchar(50) NOT NULL,
  `num_ac` varchar(50) NOT NULL,
  `dist_ac` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_cta_banc`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `cta_banc`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dat_aca`
-- 

CREATE TABLE `dat_aca` (
  `id_dat` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `level` varchar(100) collate utf8_bin NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `career_esp` varchar(100) collate utf8_bin NOT NULL,
  `name_inst` varchar(100) collate utf8_bin NOT NULL,
  `end` int(1) NOT NULL,
  `city` varchar(100) collate utf8_bin NOT NULL,
  `country` varchar(100) collate utf8_bin NOT NULL,
  `acad_title` int(1) NOT NULL,
  `revala` int(1) NOT NULL,
  `inst_revala` varchar(100) collate utf8_bin default NULL,
  `date_exp_a` date NOT NULL,
  `num_tit_a` varchar(50) collate utf8_bin NOT NULL,
  `prov_nat_title` int(1) NOT NULL,
  `revalp` int(1) NOT NULL,
  `inst_revalp` varchar(100) collate utf8_bin NOT NULL,
  `date_exp_p` date NOT NULL,
  `num_tit_p` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_dat`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `dat_aca`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dat_ed`
-- 

CREATE TABLE `dat_ed` (
  `id_dat` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `last_gra` varchar(100) NOT NULL,
  `cole` varchar(100) NOT NULL,
  `city_c` varchar(100) NOT NULL,
  `year_end` varchar(20) NOT NULL,
  `title` int(1) NOT NULL,
  PRIMARY KEY  (`id_dat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `dat_ed`
-- 

INSERT INTO `dat_ed` VALUES (1, 1, 'CUARTO DE SECUNDARIA', 'COLEGIO HUGO DAVILA', 'LA PAZ/BOLIVIA', '2012', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dat_fam`
-- 

CREATE TABLE `dat_fam` (
  `id_datf` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `type_p` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `l_name1` varchar(100) NOT NULL,
  `l_name2` varchar(100) NOT NULL,
  `sex` varchar(20) NOT NULL,
  `born_date` date NOT NULL,
  `pb_nat` varchar(100) NOT NULL,
  `tn_doc` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_datf`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `dat_fam`
-- 

INSERT INTO `dat_fam` VALUES (1, 0, 'PRIMO', 'INOCENCIO', 'LEDESMA', 'PEREZ', 'FEM', '1980-02-13', 'LA PAZ', '6089354');
INSERT INTO `dat_fam` VALUES (2, 0, 'PRIMO', 'ABEL', 'LEDESMA', 'PEREZ', 'MALE', '2012-10-04', 'LA PAZ BOLIVIANO', '3233242');
INSERT INTO `dat_fam` VALUES (3, 0, 'CUÃ±ADA', 'LUCERO', 'POZO', 'PINILLA', 'FEM', '1988-10-07', 'LA PAZ/BOLIVIA', '3123123');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `dat_lab`
-- 

CREATE TABLE `dat_lab` (
  `id_sec` int(11) NOT NULL,
  `id_per` int(11) NOT NULL,
  `name_sec` varchar(100) character set utf8 collate utf8_bin NOT NULL,
  `num_reg` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `type_sec` varchar(50) NOT NULL,
  `date_afil` date NOT NULL,
  `date_des` date NOT NULL,
  `afp` varchar(100) NOT NULL,
  `nua` varchar(50) NOT NULL,
  `ren` varchar(50) NOT NULL,
  `nit` varchar(50) NOT NULL,
  `col_prof` varchar(200) NOT NULL,
  `num_reg_col` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_sec`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `dat_lab`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `doc_uni`
-- 

CREATE TABLE `doc_uni` (
  `id_doc_uni` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `univ` varchar(200) NOT NULL,
  `asign` varchar(100) NOT NULL,
  `career` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `univ1` varchar(200) NOT NULL,
  `asign1` varchar(100) NOT NULL,
  `career1` varchar(100) NOT NULL,
  `date_start1` date NOT NULL,
  `date_end1` date NOT NULL,
  `univ2` varchar(200) NOT NULL,
  `asign2` varchar(100) NOT NULL,
  `career2` varchar(100) NOT NULL,
  `date_start2` date NOT NULL,
  `date_end2` date NOT NULL,
  `univ3` varchar(200) NOT NULL,
  `asign3` varchar(100) NOT NULL,
  `career3` varchar(100) NOT NULL,
  `date_start3` date NOT NULL,
  `date_end3` date NOT NULL,
  `univ4` varchar(200) NOT NULL,
  `asign4` varchar(100) NOT NULL,
  `career4` varchar(100) NOT NULL,
  `date_start4` date NOT NULL,
  `date_end4` date NOT NULL,
  PRIMARY KEY  (`id_doc_uni`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `doc_uni`
-- 

INSERT INTO `doc_uni` VALUES (1, 0, '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `eval_con`
-- 

CREATE TABLE `eval_con` (
  `id_eval_con` int(11) NOT NULL auto_increment,
  `id_char_con` int(11) NOT NULL,
  `date_eval` date NOT NULL,
  `res_eval` varchar(50) collate utf8_bin NOT NULL,
  `cons_eval` varchar(50) collate utf8_bin NOT NULL,
  `resp_eval` varchar(200) collate utf8_bin NOT NULL,
  `type_resp` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_eval_con`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `eval_con`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `eval_per`
-- 

CREATE TABLE `eval_per` (
  `id_eval_per` int(11) NOT NULL auto_increment,
  `id_char_per` int(11) NOT NULL,
  `date_eval` date NOT NULL,
  `res_eval` varchar(50) collate utf8_bin NOT NULL,
  `cons_eval` varchar(50) collate utf8_bin NOT NULL,
  `resp_eval` varchar(200) collate utf8_bin NOT NULL,
  `type_resp` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_eval_per`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

-- 
-- Volcar la base de datos para la tabla `eval_per`
-- 

INSERT INTO `eval_per` VALUES (1, 0, '0000-00-00', '', '', '', '');
INSERT INTO `eval_per` VALUES (2, 0, '0000-00-00', '', '', '', '');
INSERT INTO `eval_per` VALUES (3, 0, '0000-00-00', '', '', '', '');
INSERT INTO `eval_per` VALUES (4, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (5, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (6, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (7, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (8, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (9, 0, '0000-00-00', 0x4255454e4f, 0x43415041434954414349c383e2809c4e, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (10, 0, '0000-00-00', 0x4255454e4f, 0x43415041434954414349c383e2809c4e, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (11, 0, '0000-00-00', 0x455843454c454e5445, 0x52455449524f, 0x454e5249515545204d4f4f52, 0x494e4d45444941544f205355504552494f52);
INSERT INTO `eval_per` VALUES (12, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (13, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (14, 0, '0000-00-00', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);
INSERT INTO `eval_per` VALUES (15, 0, '2012-10-04', 0x4d414c4f, 0x434f4e4649524d414349c383e2809c4e2044452050554553544f, 0x454e5249515545204d4f4f52, 0x4dc383c28158494d41204155544f5249444144);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `exp_lab`
-- 

CREATE TABLE `exp_lab` (
  `id_exp_lab` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `name_inst` varchar(200) character set utf8 collate utf8_bin NOT NULL,
  `type_inst` varchar(50) NOT NULL,
  `form_ent` varchar(100) NOT NULL,
  `date_ent` date NOT NULL,
  `place_lab` varchar(200) NOT NULL,
  `charge` varchar(200) NOT NULL,
  `rea_cha` varchar(200) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `date_ret` date NOT NULL,
  PRIMARY KEY  (`id_exp_lab`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `exp_lab`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fin_con`
-- 

CREATE TABLE `fin_con` (
  `id_fin_con` int(11) NOT NULL auto_increment,
  `id_con` int(11) NOT NULL,
  `source_fin` varchar(100) NOT NULL,
  `ag_fin` varchar(200) NOT NULL,
  `prog_cat` varchar(200) NOT NULL,
  `org_unit` varchar(200) NOT NULL,
  `dep_bud` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_fin_con`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `fin_con`
-- 

INSERT INTO `fin_con` VALUES (1, 0, 'TGN', 'TGN-252', 'SADA', 'ASDASD', 'ASDASD');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fin_per`
-- 

CREATE TABLE `fin_per` (
  `id_fin_per` int(11) NOT NULL auto_increment,
  `id_per` int(11) NOT NULL,
  `source_fin` varchar(100) NOT NULL,
  `ag_fin` varchar(200) NOT NULL,
  `prog_cat` varchar(200) NOT NULL,
  `org_unit` varchar(200) NOT NULL,
  `dep_bud` varchar(200) NOT NULL,
  `item` varchar(25) NOT NULL,
  PRIMARY KEY  (`id_fin_per`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `fin_per`
-- 

INSERT INTO `fin_per` VALUES (1, 0, 'TGN-252', 'TGN-252', 'NOSE', 'CUALQUIERA', 'MMM', '828282');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `funcion`
-- 

CREATE TABLE `funcion` (
  `id_funct` int(11) NOT NULL auto_increment,
  `id_cont` int(11) default NULL,
  `id_per` int(11) default NULL,
  `date_des` date NOT NULL,
  PRIMARY KEY  (`id_funct`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `funcion`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `funcionario`
-- 

CREATE TABLE `funcionario` (
  `id_func` int(11) NOT NULL auto_increment,
  `name` varchar(512) collate utf8_bin NOT NULL,
  `l_name1` varchar(512) collate utf8_bin NOT NULL,
  `l_name2` varchar(512) collate utf8_bin NOT NULL,
  `l_name_es` varchar(512) collate utf8_bin NOT NULL,
  `nati` varchar(250) character set utf8 collate utf8_unicode_ci default NULL,
  `ci` varchar(10) collate utf8_bin NOT NULL,
  `nua` varchar(50) collate utf8_bin NOT NULL,
  `afp` varchar(100) collate utf8_bin NOT NULL,
  `expe` varchar(4) collate utf8_bin NOT NULL,
  `c_status` varchar(20) collate utf8_bin NOT NULL,
  `sex` varchar(20) collate utf8_bin NOT NULL,
  `g_blood` varchar(10) collate utf8_bin NOT NULL,
  `p_email` varchar(50) collate utf8_bin NOT NULL,
  `job_email` varchar(50) collate utf8_bin NOT NULL,
  `adress` varchar(250) collate utf8_bin NOT NULL,
  `place_res` varchar(50) collate utf8_bin NOT NULL,
  `phone_num` varchar(50) collate utf8_bin NOT NULL,
  `cel_num` varchar(50) collate utf8_bin NOT NULL,
  `phone_job` varchar(50) collate utf8_bin NOT NULL,
  `p1_born` varchar(50) collate utf8_bin default NULL,
  `p2_born` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `p3_born` varchar(50) character set utf8 collate utf8_unicode_ci default NULL,
  `date_born` varchar(50) collate utf8_bin NOT NULL,
  `lic_driv` varchar(50) collate utf8_bin NOT NULL,
  `type_lic` varchar(1) collate utf8_bin default NULL,
  `prof` varchar(1000) collate utf8_bin NOT NULL,
  `col_prof` varchar(1000) collate utf8_bin NOT NULL,
  `num_prof` varchar(100) collate utf8_bin NOT NULL,
  `nit` varchar(100) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_func`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `funcionario`
-- 

INSERT INTO `funcionario` VALUES (1, 0x4142454c20524f445249474f, 0x4c454445534d41, 0x504552455a, '', 'BOLIVIANA', 0x36303839333534, 0x31323334, 0x46555455524f, 0x4c50, 0x434153414441284f29, 0x4d, 0x4f4f52482d, 0x6976616e6140686f746d61696c2e636f6d, 0x616c656465736d61406d696e6564752e676f622e626f, 0x4d495241464c4f5245532f4e49434152414755412f35353532, 0x4c412050415a, 0x3232323238323439, 0x3730363931333939, 0x3234353233323132, 0x4c612050415a, 'MURILLO', 'la paz', 0x313938332d30332d3133, 0x3132333132, 0x41, 0x434f4e5441444f52, 0x434f4c4547494f20444520434f4e5441444f52455320444520424f4c49564941, 0x31323334, 0x36303839333534303135);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `lang_func`
-- 

CREATE TABLE `lang_func` (
  `id_lang` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `descp` varchar(100) collate utf8_bin NOT NULL,
  `read_l` varchar(10) collate utf8_bin NOT NULL,
  `speak_l` varchar(10) collate utf8_bin NOT NULL,
  `write_l` varchar(10) collate utf8_bin NOT NULL,
  `descp1` varchar(100) collate utf8_bin NOT NULL,
  `read_l1` varchar(10) collate utf8_bin NOT NULL,
  `speak_l1` varchar(10) collate utf8_bin NOT NULL,
  `write_l1` varchar(10) collate utf8_bin NOT NULL,
  `descp2` varchar(100) collate utf8_bin NOT NULL,
  `read_l2` varchar(10) collate utf8_bin NOT NULL,
  `speak_l2` varchar(10) collate utf8_bin NOT NULL,
  `write_l2` varchar(10) collate utf8_bin NOT NULL,
  `descp3` varchar(100) collate utf8_bin NOT NULL,
  `read_l3` varchar(10) collate utf8_bin NOT NULL,
  `speak_l3` varchar(10) collate utf8_bin NOT NULL,
  `write_l3` varchar(10) collate utf8_bin NOT NULL,
  `descp4` varchar(100) collate utf8_bin NOT NULL,
  `read_l4` varchar(10) collate utf8_bin NOT NULL,
  `speak_l4` varchar(10) collate utf8_bin NOT NULL,
  `write_l4` varchar(10) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `lang_func`
-- 

INSERT INTO `lang_func` VALUES (1, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `movilidad`
-- 

CREATE TABLE `movilidad` (
  `id_mov` int(11) NOT NULL auto_increment,
  `id_cont` int(11) default NULL,
  `id_per` int(11) default NULL,
  `date_des` date NOT NULL,
  PRIMARY KEY  (`id_mov`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `movilidad`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `old_cas`
-- 

CREATE TABLE `old_cas` (
  `id_old_cas` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `date_start` date NOT NULL,
  `date_last` date NOT NULL,
  `year_rat` int(2) NOT NULL,
  `month_rat` int(2) NOT NULL,
  `day_rat` int(2) NOT NULL,
  PRIMARY KEY  (`id_old_cas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `old_cas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `old_mov`
-- 

CREATE TABLE `old_mov` (
  `id_old_mov` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `charge` varchar(500) NOT NULL,
  `rea_chan` varchar(50) NOT NULL,
  `num_res` varchar(50) NOT NULL,
  `gral_dir` varchar(500) NOT NULL,
  `unit` varchar(500) NOT NULL,
  `area` varchar(100) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  PRIMARY KEY  (`id_old_mov`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- Volcar la base de datos para la tabla `old_mov`
-- 

INSERT INTO `old_mov` VALUES (1, 0, 'jardinero', 'ROTACIÃ“N', '212312', 'cualquiera', 'recursos', 'contabilidad', '0000-00-00', '0000-00-00');
INSERT INTO `old_mov` VALUES (2, 0, 'jardinero', 'ROTACIÃ“N', '212312', 'cualquiera', 'recursos', 'contabilidad', '0000-00-00', '0000-00-00');
INSERT INTO `old_mov` VALUES (3, 0, 'JARDINERO', 'ROTACIÃ“N', '212312', 'CUALQUIERA', 'RECURSOS', 'CONTABILIDAD', '2012-10-11', '2012-10-23');
INSERT INTO `old_mov` VALUES (4, 0, 'CONTA', 'PROMOCIÃ“N', '231', 'POR AHI', 'COLEGIO?', 'SI CREO', '2012-10-05', '2012-10-25');
INSERT INTO `old_mov` VALUES (5, 0, 'AHORA NOSE', 'TRANFERENCIA', '12312', 'PRESIDENTE', 'ERER', 'LISTA', '2012-10-12', '2012-10-17');
INSERT INTO `old_mov` VALUES (6, 0, 'AHORA CREO PROGRAMADOR', 'ROTACIÃ“N', '23123', 'MIRAFLORES', 'CONTA', 'LISTO', '2012-10-11', '2012-10-31');
INSERT INTO `old_mov` VALUES (7, 0, '2012-10-05', '2012-10-18', 'PHP Y FRAMEWORKS', 'EXTERNA', 'CONSULTORIA', 'LA PAZ/BOLIVIA', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ot_con`
-- 

CREATE TABLE `ot_con` (
  `id_ot_con` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `desc_o` varchar(100) collate utf8_bin NOT NULL,
  `level` varchar(10) collate utf8_bin NOT NULL,
  `desc_o1` varchar(100) collate utf8_bin NOT NULL,
  `level1` varchar(10) collate utf8_bin NOT NULL,
  `desc_o2` varchar(100) collate utf8_bin NOT NULL,
  `level2` varchar(10) collate utf8_bin NOT NULL,
  `desc_o3` varchar(100) collate utf8_bin NOT NULL,
  `level3` varchar(10) collate utf8_bin NOT NULL,
  `desc_o4` varchar(100) collate utf8_bin NOT NULL,
  `level4` varchar(10) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id_ot_con`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `ot_con`
-- 

INSERT INTO `ot_con` VALUES (1, 0, '', 0x4dc383c28158494d41532041, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permanente`
-- 

CREATE TABLE `permanente` (
  `id_per` int(11) NOT NULL,
  `id_func` int(11) NOT NULL,
  `date_ent` date NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY  (`id_per`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `permanente`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permisos`
-- 

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL auto_increment,
  `id_user` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `tiempo` decimal(11,1) NOT NULL,
  `fecha_i` varchar(24) collate utf8_bin NOT NULL,
  `fecha_ii` date NOT NULL,
  `hrs_i` time NOT NULL,
  `fecha_f` varchar(24) collate utf8_bin NOT NULL,
  `fecha_ff` date NOT NULL,
  `hrs_f` time NOT NULL,
  `obs` tinytext collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `permisos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `prestamos`
-- 

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `fecha_salida` date NOT NULL,
  `fecha_retorno` date NOT NULL,
  `observaciones` tinytext collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `prestamos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `renuncia`
-- 

CREATE TABLE `renuncia` (
  `id_ren` int(11) NOT NULL,
  `id_cont` int(11) NOT NULL,
  `date_pres` date NOT NULL,
  `date_efec` date NOT NULL,
  PRIMARY KEY  (`id_ren`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- 
-- Volcar la base de datos para la tabla `renuncia`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `soc_secu`
-- 

CREATE TABLE `soc_secu` (
  `id_sec` int(11) NOT NULL auto_increment,
  `id_per` int(11) NOT NULL,
  `name_sec` varchar(100) NOT NULL,
  `num_reg` varchar(50) NOT NULL,
  `date_afil` date NOT NULL,
  `date_des` date NOT NULL,
  PRIMARY KEY  (`id_sec`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `soc_secu`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ult_decl`
-- 

CREATE TABLE `ult_decl` (
  `id_ult_decl` int(11) NOT NULL auto_increment,
  `id_per` int(11) NOT NULL,
  `date_dbr` date NOT NULL,
  `date_di` date NOT NULL,
  PRIMARY KEY  (`id_ult_decl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `ult_decl`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `user`
-- 

CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `username` varchar(512) collate utf8_bin NOT NULL,
  `password` varchar(1024) collate utf8_bin NOT NULL,
  `permisos` int(11) NOT NULL,
  `nombre` varchar(500) collate utf8_bin NOT NULL,
  `ap_1` varchar(500) collate utf8_bin NOT NULL,
  `ap_2` varchar(500) collate utf8_bin NOT NULL,
  `type` int(1) NOT NULL,
  `fuente` varchar(50) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `user`
-- 

INSERT INTO `user` VALUES (1, 1, 0x4c5041313330333833, 0x36303839333534, 0, 0x4142454c20524f445249474f, 0x4c454445534d41, 0x504552455a, 1, 0x54474e);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `vacaciones`
-- 

CREATE TABLE `vacaciones` (
  `id` int(11) NOT NULL auto_increment,
  `id_func` int(11) NOT NULL,
  `gestion_1` varchar(24) collate utf8_bin NOT NULL,
  `dias_g1` decimal(11,1) NOT NULL,
  `gestion_2` varchar(24) collate utf8_bin NOT NULL,
  `dias_g2` decimal(11,1) NOT NULL,
  `observaciones` varchar(1024) collate utf8_bin NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=355 ;

-- 
-- Volcar la base de datos para la tabla `vacaciones`
-- 

INSERT INTO `vacaciones` VALUES (1, 1, 0x323030392d32303130, 10.0, 0x323031302d32303131, 30.0, 0x616c2030342f30352f3230313220352064696173);
INSERT INTO `vacaciones` VALUES (2, 2, 0x323031302d32303131, 19.5, 0x323031312d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (3, 3, 0x323031312d32303132, 14.5, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (4, 4, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (5, 5, 0x323031312d32303132, 10.5, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (6, 6, 0x323031312d32303132, 17.0, '', 0.0, 0x4e4f205245474953545241205041562c20666f726d2076616320616c2032342f30312f323031322c20666f726d207661632032372f30382f323031322d3564);
INSERT INTO `vacaciones` VALUES (7, 7, 0x323031302d32303131, 12.0, 0x323031312d32303132, 15.0, '');
INSERT INTO `vacaciones` VALUES (8, 8, 0x323030392d32303130, 11.5, 0x323031302d32303131, 15.0, 0x31322f30382f323031312d4e4f2052454749535452412050415620);
INSERT INTO `vacaciones` VALUES (9, 9, 0x323031302d32303131, 25.5, 0x323031312d32303132, 30.0, 0x30312f30392f323031312d4e4f20524547495354524120504156204e4920464f524d2e205641432e);
INSERT INTO `vacaciones` VALUES (10, 10, 0x323031302d32303131, 24.0, 0x323031312d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (11, 11, 0x323031322d32303133, 0.0, '', 0.0, 0x4e4f20434f52524553504f4e4445205641434143494f4e);
INSERT INTO `vacaciones` VALUES (12, 12, 0x323031302d32303131, 30.0, '', 0.0, 0x4e4f205245474953545241205045524d49534f532041204355454e5441204445205641434143494f4e);
INSERT INTO `vacaciones` VALUES (13, 13, 0x323031322d32303133, 0.0, '', 0.0, 0x4e4f20434f52524553504f4e4445);
INSERT INTO `vacaciones` VALUES (14, 14, 0x323030392d32303130, 22.0, 0x323031302d32303131, 30.0, '');
INSERT INTO `vacaciones` VALUES (15, 15, 0x323031312d32303132, 15.0, '', 0.0, 0x4e4f20524547495354524120504156);
INSERT INTO `vacaciones` VALUES (16, 16, 0x323031302d32303131, 0.0, 0x323031312d32303132, 8.0, 0x56455249462e);
INSERT INTO `vacaciones` VALUES (17, 17, 0x323031302d32303131, 20.0, 0x323031312d32303132, 30.0, 0x4e4f205245474953545241205041562e20414c2033302f30342f323031322c2050414320414c2030312f30382f32303132);
INSERT INTO `vacaciones` VALUES (18, 18, 0x323031302d32303131, 11.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (19, 21, 0x323031302d32303131, 20.0, 0x323031312d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (20, 22, 0x323031302d32303131, 0.0, 0x323031312d32303132, 9.5, 0x464f524d2e205641432e20414c2030352f30372f32303132);
INSERT INTO `vacaciones` VALUES (21, 23, 0x323030392d32303130, 8.0, 0x323031302d32303131, 30.0, '');
INSERT INTO `vacaciones` VALUES (22, 24, 0x323031312d32303132, 0.0, '', 0.0, 0x4e4f20434f52524553504f4e444520);
INSERT INTO `vacaciones` VALUES (23, 25, 0x323031312d32303132, 11.0, '', 0.0, 0x31352f30322f32303132202d20342044494153);
INSERT INTO `vacaciones` VALUES (24, 26, 0x323031302d32303131, 12.5, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (25, 27, 0x323031302d32303131, 16.5, 0x323031312d32303132, 30.0, 0x464f524d2e205641432e2030332d30392d323031322d313044);
INSERT INTO `vacaciones` VALUES (26, 28, 0x323031302d32303131, 30.0, 0x323031302d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (27, 29, 0x323031322d32303133, 0.0, '', 0.0, 0x4e4f20434f52524553504f4e444520564143);
INSERT INTO `vacaciones` VALUES (28, 30, 0x323031312d32303132, 15.0, '', 0.0, 0x4e4f20524547495354524120504156);
INSERT INTO `vacaciones` VALUES (29, 31, 0x323031302d32303131, 11.0, 0x323031312d32303132, 20.0, 0x6e6f2072656769737472612c20666f726d2e207661632e20616c2030372f30382f323031322d34);
INSERT INTO `vacaciones` VALUES (30, 32, 0x323031312d32303132, 30.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (31, 33, 0x323031302d32303131, 0.0, 0x323031312d32303132, 11.5, 0x464f524d204445205641432e2031302f31302f323031312c20464f524d2e205641432e20414c2030372f30382f32303132);
INSERT INTO `vacaciones` VALUES (32, 34, 0x323030392d32303130, 12.0, 0x323031302d32303131, 30.0, 0x554c542e20464f524d2056414332322f31322f32303131203135204449415320);
INSERT INTO `vacaciones` VALUES (33, 35, 0x323031302d32303131, 7.5, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (34, 36, 0x323031312d32303132, 0.0, '', 0.0, 0x4e4f20434f52524553504f4e444520564143);
INSERT INTO `vacaciones` VALUES (35, 37, 0x323031312d32303132, 13.5, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (36, 38, 0x323031302d32303131, 6.5, 0x323031312d32303132, 15.0, '');
INSERT INTO `vacaciones` VALUES (37, 39, 0x323031302d32303131, 19.0, 0x323031312d32303132, 30.0, 0x666f726d756c6172696f20616c2031392f30342f32303132);
INSERT INTO `vacaciones` VALUES (38, 40, 0x323031322d32303133, 0.0, '', 0.0, 0x6e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (39, 41, 0x323031302d32303131, 20.5, 0x323031312d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (40, 42, 0x323031302d32303131, 9.5, 0x323031312d32303132, 15.0, '');
INSERT INTO `vacaciones` VALUES (41, 43, 0x323031302d32303131, 3.0, 0x323031312d32303132, 15.0, '');
INSERT INTO `vacaciones` VALUES (42, 44, 0x323031312d32303132, 17.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (43, 45, 0x323031312d32303132, 13.5, '', 0.0, 0x707020616c2030322f30342f32303132);
INSERT INTO `vacaciones` VALUES (44, 46, 0x323031302d32303131, 3.0, '', 0.0, 0x707020616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (45, 47, 0x323031312d32303132, 5.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (46, 48, 0x323031322d32303133, 0.0, '', 0.0, 0x41554e204e4f20434f52524553504f4e4445);
INSERT INTO `vacaciones` VALUES (47, 49, 0x323031302d32303131, 20.0, '', 0.0, 0x464f524d205641432e20414c2032352f30342f32303132);
INSERT INTO `vacaciones` VALUES (48, 50, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (49, 51, 0x323030392d32303130, 11.5, 0x323031302d32303131, 30.0, 0x70616320616c2030312f30332f32303132);
INSERT INTO `vacaciones` VALUES (50, 52, 0x323031302d32303131, 11.0, 0x323031312d32303132, 15.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (51, 53, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, '');
INSERT INTO `vacaciones` VALUES (52, 54, 0x323031312d32303132, 13.0, '', 0.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (53, 55, 0x323031302d32303131, 11.5, '', 0.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (54, 56, 0x323031302d32303131, 8.5, 0x323031312d32303132, 15.0, 0x70616320616c2031382f30352f32303132);
INSERT INTO `vacaciones` VALUES (55, 57, 0x323031312d32303132, 3.0, '', 0.0, 0x666f726d2076616320616c2030352f30332f32303132);
INSERT INTO `vacaciones` VALUES (56, 58, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661632e);
INSERT INTO `vacaciones` VALUES (57, 59, 0x323031302d32303131, 14.0, 0x323031312d32303132, 15.0, 0x70616320616c2030352f30342f32303132);
INSERT INTO `vacaciones` VALUES (58, 60, 0x323031302d32303131, 30.0, 0x323031312d32303132, 29.5, 0x70616320616c2031392f30332f32303132);
INSERT INTO `vacaciones` VALUES (59, 61, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (60, 62, 0x323031312d32303132, 23.0, '', 0.0, 0x70616320616c2033312f30352f32303132);
INSERT INTO `vacaciones` VALUES (61, 63, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (62, 64, 0x323031302d32303131, 3.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (63, 65, 0x323031302d32303131, 11.5, 0x323031312d32303132, 15.0, 0x70616320616c2031382f30352f32303132);
INSERT INTO `vacaciones` VALUES (64, 66, 0x323031312d32303132, 14.0, '', 0.0, 0x70616320616c2030332f30352f32303132);
INSERT INTO `vacaciones` VALUES (65, 67, 0x323031302d32303131, 27.0, '', 0.0, 0x70616320616c2030332f30352f32303132);
INSERT INTO `vacaciones` VALUES (66, 68, 0x323031302d32303131, 29.0, 0x323031312d32303132, 30.0, '');
INSERT INTO `vacaciones` VALUES (67, 69, 0x323031312d32303132, 12.0, '', 0.0, 0x70616320616c2033302f30332f32303132);
INSERT INTO `vacaciones` VALUES (68, 70, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (69, 71, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (70, 72, 0x323030392d32303130, 0.0, 0x323031302d32303131, 15.0, 0x70616320616c2032332f30332f32303132);
INSERT INTO `vacaciones` VALUES (71, 73, 0x323031312d32303132, 0.0, '', 0.0, 0x41554e204e4f20434f52524553504f4e4445205641434143494f4e4553);
INSERT INTO `vacaciones` VALUES (72, 74, 0x323031302d32303131, 12.5, '', 0.0, 0x70616320616c2031382f30362f32303132);
INSERT INTO `vacaciones` VALUES (73, 75, 0x323031302d32303131, 11.0, 0x323031312d32303132, 15.0, 0x70616320616c2031322f30362f32303132);
INSERT INTO `vacaciones` VALUES (74, 76, 0x323031302d32303131, 14.0, 0x323031312d32303132, 15.0, 0x70616320616c2032382f30352f32303132);
INSERT INTO `vacaciones` VALUES (75, 77, 0x323031312d32303132, 7.0, '', 0.0, 0x70616320616c2031392f30362f32303132);
INSERT INTO `vacaciones` VALUES (76, 78, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e);
INSERT INTO `vacaciones` VALUES (77, 79, 0x323031302d32303131, 1.5, 0x323031312d32303132, 15.0, 0x666f726d2e207661632e20616c2031352f30362f323031322c20464f524d2e205641432e20414c2031372f30372f32303132202d2035);
INSERT INTO `vacaciones` VALUES (78, 80, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (79, 81, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f207265676973747261207061632e206f20666f726d2e20766163);
INSERT INTO `vacaciones` VALUES (80, 82, 0x323031302d32303131, 12.0, '', 0.0, 0x6e6f207265676973747261207061632e206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (81, 83, 0x323031302d32303131, 5.5, 0x323031312d32303132, 15.0, 0x70616320616c2030342f30362f32303132);
INSERT INTO `vacaciones` VALUES (82, 84, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (83, 85, 0x323031302d32303131, 21.0, 0x323031312d32303132, 30.0, 0x666f726d2e207661632e2030322f30342f32303132);
INSERT INTO `vacaciones` VALUES (84, 86, 0x323031312d32303132, 14.0, '', 0.0, 0x70616320616c20342f30362f32303132);
INSERT INTO `vacaciones` VALUES (85, 87, 0x323031312d32303132, 11.0, '', 0.0, 0x70616320616c2030342f30362f32303132);
INSERT INTO `vacaciones` VALUES (86, 88, 0x323030392d32303130, 4.5, 0x323031302d32303131, 30.0, 0x70616320616c2032382f30352f323031322c2070616320616c2032332f30372f323031322c2020666f726d2e207661632e2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (87, 89, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (88, 90, 0x323031302d32303131, 13.5, 0x323031312d32303132, 15.0, 0x70616320616c2032302f30342f32303132);
INSERT INTO `vacaciones` VALUES (89, 91, 0x323031302d32303131, 8.0, 0x323031312d32303132, 15.0, 0x70616320616c2030352f30332f32303132);
INSERT INTO `vacaciones` VALUES (90, 92, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x666f726d2e2076616320616c2030392f31312f32303131);
INSERT INTO `vacaciones` VALUES (91, 93, 0x323031302d32303131, 27.0, 0x323031312d32303132, 30.0, 0x666f726d2e207661632e20616c2032382f31312f32303131);
INSERT INTO `vacaciones` VALUES (92, 94, 0x323030392d32303130, 23.0, 0x323031302d32303131, 30.0, 0x70616320616c2031342f30362f32303132);
INSERT INTO `vacaciones` VALUES (93, 95, 0x323031302d32303131, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d207661632e);
INSERT INTO `vacaciones` VALUES (94, 96, 0x323031312d32303132, 14.5, '', 0.0, 0x70616320616c2031312f30352f32303132);
INSERT INTO `vacaciones` VALUES (95, 97, 0x323031302d32303131, 8.0, 0x323031312d32303132, 15.0, 0x70616320616c2032372f30312f32303132);
INSERT INTO `vacaciones` VALUES (96, 98, 0x323031312d32303132, 14.0, '', 0.0, 0x70616320616c2030372f30352f32303132);
INSERT INTO `vacaciones` VALUES (97, 99, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (98, 100, 0x323031312d32303132, 8.0, '', 0.0, 0x666f726d2e207661632e2031382f30352f32303132);
INSERT INTO `vacaciones` VALUES (99, 101, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (100, 102, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (101, 103, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (102, 104, 0x323031302d32303131, 0.0, 0x323031312d32303132, 26.0, 0x70616320616c2032352f30362f32303132202d20323031302d32303131204345525241444f);
INSERT INTO `vacaciones` VALUES (103, 105, 0x323031312d32303132, 0.0, '', 0.0, 0x7661636163696f6e6573206365727261646173);
INSERT INTO `vacaciones` VALUES (104, 106, 0x323030392d32303130, 0.0, 0x323031302d32303131, 21.0, 0x666f726d2e207661632e2031392f31322f323031322c2070616320616c2032332f30342f32303132);
INSERT INTO `vacaciones` VALUES (105, 107, 0x323031302d32303131, 0.5, 0x323031312d32303132, 15.0, 0x50414320414c2031342f30352f323031322c20666f726d2e207661632e20616c2031332f30372f32303132);
INSERT INTO `vacaciones` VALUES (106, 108, 0x323031312d32303132, 10.0, '', 0.0, 0x666f726d2076616320616c2031382f30362f32303132);
INSERT INTO `vacaciones` VALUES (107, 109, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (108, 110, 0x323031302d32303131, 13.0, 0x323031312d32303132, 15.0, 0x6e6f2072656769737472617220666f726d2e207661632e202d2070616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (109, 111, 0x323031302d32303131, 13.0, '', 0.0, 0x666f726d2076616320616c202030362f30322f32303132);
INSERT INTO `vacaciones` VALUES (110, 112, 0x323031302d32303131, 15.0, '', 0.0, 0x6e6f20726567697374726120702e2061632e206e6920666f726d2e20766163);
INSERT INTO `vacaciones` VALUES (111, 113, 0x323031302d32303131, 12.0, 0x323031312d32303132, 15.0, 0x70616320616c2031372f30342f32303132);
INSERT INTO `vacaciones` VALUES (112, 114, 0x323031312d32303132, 9.0, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (113, 115, 0x323031312d32303132, 14.5, '', 0.0, 0x6e6f20726567697374726120666f726d2e207661632e206e69207061632e20);
INSERT INTO `vacaciones` VALUES (114, 116, 0x323031312d32303132, 14.5, '', 0.0, 0x70616320616c2032382f30332f32303132);
INSERT INTO `vacaciones` VALUES (115, 117, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (116, 118, 0x323031312d32303132, 14.0, '', 0.0, 0x7061632032362f30332f32303132);
INSERT INTO `vacaciones` VALUES (117, 119, 0x323030392d32303130, 15.0, 0x323031302d32303131, 30.0, 0x50414320414c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (118, 120, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (119, 121, 0x323031302d32303131, 27.5, 0x323031312d32303132, 30.0, 0x70616320616c2031352f30362f32303132);
INSERT INTO `vacaciones` VALUES (120, 122, 0x323031302d32303131, 14.0, 0x323031312d32303132, 30.0, 0x70616320616c2032322f30322f323031322c20666f726d2e207661632e20616c2030392f30372f323031322c20666f726d2e207661632e20616c2030332f30392f32303132202d313064);
INSERT INTO `vacaciones` VALUES (121, 123, 0x323031302d32303131, 10.5, '', 0.0, 0x70616320616c2031382f30342f32303132);
INSERT INTO `vacaciones` VALUES (122, 124, 0x323031302d32303131, 10.0, 0x323031312d32303132, 15.0, 0x70616320616c2030372f30352f32303132);
INSERT INTO `vacaciones` VALUES (123, 125, 0x323031302d32303131, 4.0, 0x323031312d32303132, 15.0, 0x70616320616c2032322f30322f32303132);
INSERT INTO `vacaciones` VALUES (124, 126, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (125, 127, 0x323031302d32303131, 0.0, 0x323031312d32303132, 11.5, 0x70616320616c2032352f30352f32303132202d204f4a4f2c2020666f726d2e207661632e2032372f30382f323031322d313064);
INSERT INTO `vacaciones` VALUES (126, 128, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (127, 129, 0x323031302d32303131, 0.0, 0x323031312d32303132, 14.5, 0x666f726d2e2076616320616c2031322f31322f323031312c20464f524d2e205641432e20414c2032332f30372f32303132);
INSERT INTO `vacaciones` VALUES (128, 130, 0x323031302d32303131, 4.5, 0x323031312d32303132, 15.0, 0x70616320616c2032322f30322f32303132);
INSERT INTO `vacaciones` VALUES (129, 131, 0x323031302d32303131, 8.0, 0x323031312d32303132, 15.0, 0x70616320616c2031302f30312f32303131206e6f20666f726d207661632e2c20666f726d2e207661632032372f30382f323031322d3564);
INSERT INTO `vacaciones` VALUES (130, 132, 0x323031312d32303132, 12.5, '', 0.0, 0x70616320616c2032322f30332f32303132);
INSERT INTO `vacaciones` VALUES (131, 133, 0x323031312d32303132, 10.5, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (132, 134, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x666f726d2076616320616c2032302f30392f32303131);
INSERT INTO `vacaciones` VALUES (133, 135, 0x323031312d32303132, 26.0, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (134, 136, 0x323031302d32303131, 8.0, '', 0.0, 0x70616320616c2030382f30362f323031322c2079206f74726f732064652067657374696f6e2032303131);
INSERT INTO `vacaciones` VALUES (135, 137, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (136, 138, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x70616320616c2030332f30392f32303131);
INSERT INTO `vacaciones` VALUES (137, 139, 0x323030392d32303130, 13.0, 0x323031302d32303131, 30.0, 0x70616320616c20312f30362f32303132);
INSERT INTO `vacaciones` VALUES (138, 140, 0x323031302d32303131, 0.0, '', 0.0, 0x70616320616c2030362f30322f323031322c20464f524d2e205641432e20414c2032392f30362f32303132);
INSERT INTO `vacaciones` VALUES (139, 141, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (140, 142, 0x323031302d32303131, 14.5, 0x323031312d32303132, 15.0, 0x666f726d2e207661632e20616c2031392f31322f32303131);
INSERT INTO `vacaciones` VALUES (141, 143, 0x323031312d32303132, 13.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (142, 144, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (143, 145, 0x323031312d32303132, 0.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e20766163202d204345525241444f20504f522042414a4120);
INSERT INTO `vacaciones` VALUES (144, 146, 0x323031312d32303132, 17.0, '', 0.0, 0x70616320616c2030322f30342f32303132);
INSERT INTO `vacaciones` VALUES (145, 147, 0x323031302d32303131, 9.0, '', 0.0, 0x70616320616c2032362f30332f323031322c20464f524d2e205641432e20414c2030392f30372f32303132202d2035);
INSERT INTO `vacaciones` VALUES (146, 148, 0x323030392d32303130, 18.0, 0x323031302d32303131, 30.0, 0x70616320616c2032382f30352f32303132);
INSERT INTO `vacaciones` VALUES (147, 149, 0x323030392d32303130, 27.0, 0x323031302d32303131, 30.0, 0x70616320616c2032382f30392f32303131);
INSERT INTO `vacaciones` VALUES (148, 150, 0x323031312d32303132, 14.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (149, 151, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (150, 152, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x6e6f20726567697374726120706163206e6920666f726d207661632e2061637475616c202d206e6f2063617320656e2066696c65206e6920656e20696e666f726d652028616e746572696f72657320666f726d732e20617369676e616e203330206469617320706f722067657374696f6e29);
INSERT INTO `vacaciones` VALUES (151, 153, 0x323031312d32303132, 13.0, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (152, 154, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x2a206e6f20726567697374726120706163206e6920666f726d2e207661632e2061637475616c2c20666f726d2e207661632e20616c2033302f30372f32303132);
INSERT INTO `vacaciones` VALUES (153, 155, 0x323031302d32303131, 27.0, 0x323031312d32303132, 30.0, 0x2a70616320616c2031342f30362f32303132);
INSERT INTO `vacaciones` VALUES (154, 156, 0x323031312d32303132, 13.5, '', 0.0, 0x70616320616c2032352f30352f32303132);
INSERT INTO `vacaciones` VALUES (155, 157, 0x323030392d32303130, 28.0, 0x323031302d32303131, 30.0, 0x70616320616c2030362f30362f32303132);
INSERT INTO `vacaciones` VALUES (156, 158, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (157, 159, 0x323031302d32303131, 17.0, 0x323031312d32303132, 30.0, 0x666f726d2076616320616c2032312f30352f32303132);
INSERT INTO `vacaciones` VALUES (158, 160, 0x323031302d32303131, 10.0, '', 0.0, 0x70616320616c2030342f30362f32303132);
INSERT INTO `vacaciones` VALUES (159, 161, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x2a756c74696d6f73207061632076616e206120636f6e746162696c697a6172736520636f6e2067657374696f6e20323030392d32303130);
INSERT INTO `vacaciones` VALUES (160, 162, 0x323031312d32303132, 12.0, '', 0.0, 0x70616320616c2031302f30352f32303132);
INSERT INTO `vacaciones` VALUES (161, 163, 0x323031302d32303131, 20.0, 0x323031312d32303132, 20.0, 0x70616320616c2032382f30352f32303132);
INSERT INTO `vacaciones` VALUES (162, 164, 0x323031312d32303132, 12.5, '', 0.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (163, 165, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (164, 166, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (165, 167, 0x323031302d32303131, 0.0, 0x323031312d32303132, 12.0, 0x70616320616c2032382f30352f323031322c20666f726d2e207661632e20616c2030392f30372f32303132);
INSERT INTO `vacaciones` VALUES (166, 168, 0x323031302d32303131, 7.5, 0x323031312d32303132, 15.0, 0x70616320616c2031382f30352f32303132);
INSERT INTO `vacaciones` VALUES (167, 169, 0x323031302d32303131, 13.0, '', 0.0, 0x70616320616c2030342f30342f32303132);
INSERT INTO `vacaciones` VALUES (168, 170, 0x323031302d32303131, 27.0, 0x323031312d32303132, 30.0, 0x7061632030342f30342f32303132);
INSERT INTO `vacaciones` VALUES (169, 171, 0x323031302d32303131, 16.5, '', 0.0, 0x666f726d2076616320616c2031302f30342f32303132);
INSERT INTO `vacaciones` VALUES (170, 172, 0x323031302d32303131, 17.0, 0x323031312d32303132, 30.0, 0x70616320616c2032322f30362f323031322c20666f726d2e207661632e20616c2032332f30372f32303132202d20322e352028746172646573292c20666f726d2e207661632e20616c2032302f30382f32303132202d20352e35);
INSERT INTO `vacaciones` VALUES (171, 173, 0x323031302d32303131, 14.0, 0x323031312d32303132, 15.0, 0x70616320616c2032322f30362f32303131);
INSERT INTO `vacaciones` VALUES (172, 174, 0x323031302d32303131, 5.5, 0x323031312d32303132, 20.0, 0x70616320616c2031352f30362f323031322c2066756e63696f6172696f2064696a6f20712070726573656e746f204341532072656369656e74656d656e7465);
INSERT INTO `vacaciones` VALUES (173, 175, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (174, 176, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (175, 177, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (176, 178, 0x323030392d32303130, 5.5, 0x323031302d32303131, 15.0, '');
INSERT INTO `vacaciones` VALUES (177, 179, 0x323031302d32303131, 8.5, 0x323031312d32303132, 15.0, 0x70616320616c2031352f30362f32303132);
INSERT INTO `vacaciones` VALUES (178, 180, 0x323031312d32303132, 12.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (179, 181, 0x323031302d32303131, 14.0, '', 0.0, 0x70616320616c2030362f30362f32303132);
INSERT INTO `vacaciones` VALUES (180, 182, 0x323031302d32303131, 11.0, 0x323031312d32303132, 15.0, 0x70616320616c2032302f30362f32303132);
INSERT INTO `vacaciones` VALUES (181, 183, 0x323031302d32303131, 29.5, 0x323031312d32303132, 30.0, 0x6e6f20726567697374726120706163206e6920666f726d2e206c7565676f2064656c2030332f30372f32303132);
INSERT INTO `vacaciones` VALUES (182, 184, 0x323031302d32303131, 2.5, 0x323031312d32303132, 15.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (183, 185, 0x323030392d32303130, 0.0, 0x323031302d32303131, 29.0, 0x70616320616c2033312f30352f32303132);
INSERT INTO `vacaciones` VALUES (184, 186, 0x323030392d32303130, 16.5, 0x323031302d32303131, 20.0, 0x70616320616c2031342f30392f32303131);
INSERT INTO `vacaciones` VALUES (185, 187, 0x323031312d32303131, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (186, 188, 0x323031312d32303132, 10.0, '', 0.0, 0x736567756e20666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (187, 189, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (188, 190, 0x323031302d32303131, 9.0, '', 0.0, 0x70616320616c2030342f30342f32303132);
INSERT INTO `vacaciones` VALUES (189, 191, 0x323031302d32303131, 30.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (190, 192, 0x323031302d32303131, 7.0, 0x323031312d32303132, 15.0, 0x70616320616c2031322f30362f32303132);
INSERT INTO `vacaciones` VALUES (191, 193, 0x323031302d32303131, 13.0, 0x323031312d32303132, 15.0, 0x70616320616c2031382f30352f32303132);
INSERT INTO `vacaciones` VALUES (192, 194, 0x323031302d32303131, 6.5, 0x323031312d32303132, 15.0, 0x70616320616c2030352f30362f32303132);
INSERT INTO `vacaciones` VALUES (193, 195, 0x323031302d32303131, 8.0, 0x323031312d32303132, 15.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (194, 196, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (195, 197, 0x323030392d32303130, 4.0, 0x323031302d32303131, 30.0, 0x666f726d2e207661632e2030312f30362f32303132);
INSERT INTO `vacaciones` VALUES (196, 198, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x666f726d2076616320616c2030332f30312f32303132);
INSERT INTO `vacaciones` VALUES (197, 199, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (198, 200, 0x323031302d32303131, 24.5, 0x323031312d32303132, 30.0, 0x50414320414c2031322f30362f32303132);
INSERT INTO `vacaciones` VALUES (199, 201, 0x323030392d32303130, 14.5, 0x323031302d32303131, 30.0, 0x70616320616c2032392f30352f32303132);
INSERT INTO `vacaciones` VALUES (200, 202, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (201, 203, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e2061637475616c);
INSERT INTO `vacaciones` VALUES (202, 204, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (203, 205, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (204, 206, 0x323030392d32303130, 4.0, 0x323031302d32303131, 15.0, 0x70616320616c2032312f30352f32303132);
INSERT INTO `vacaciones` VALUES (205, 207, 0x323031302d32303131, 11.0, '', 0.0, 0x70616320616c2031372f30352f32303132202d20323030392d323031303a206365727261646f);
INSERT INTO `vacaciones` VALUES (206, 208, 0x323031312d32303132, 13.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (207, 209, 0x323031302d32303131, 13.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (208, 210, 0x323031302d32303131, 15.0, '', 0.0, 0x666f726d2e207661632e20616c2030322f30372f32303132);
INSERT INTO `vacaciones` VALUES (209, 211, 0x323031302d32303131, 5.0, '', 0.0, 0x666f726d207661632030362f30322f32303132);
INSERT INTO `vacaciones` VALUES (210, 212, 0x323031302d32303131, 25.0, 0x323031312d32303132, 30.0, 0x666f726d2e207661632e2032322f30322f32303132202d2070657264696f2067657374696f6e20323030392d323031303a20313820646961732c20464f524d2e205641432e20414c2032302f30382f32303132202d2035);
INSERT INTO `vacaciones` VALUES (211, 213, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e2061637475616c2c20756c74696d6f20616c2030372f30362f32303131);
INSERT INTO `vacaciones` VALUES (212, 214, 0x323031302d32303131, 12.0, 0x323031312d32303132, 15.0, 0x70616320616c2031322f30362f32303132);
INSERT INTO `vacaciones` VALUES (213, 215, 0x323031302d32303131, 1.5, 0x323031312d32303132, 20.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (214, 216, 0x323031302d32303131, 0.0, 0x323031312d32303132, 15.0, 0x666f726d2e207661632e20616c2031372f31302f32303131);
INSERT INTO `vacaciones` VALUES (215, 217, 0x323031302d32303131, 14.5, 0x323031312d32303132, 15.0, 0x70616320616c2032372f31302f32303131);
INSERT INTO `vacaciones` VALUES (216, 218, 0x323030392d32303130, 17.0, 0x323031302d32303131, 30.0, 0x70616320616c2031382f30362f32303132);
INSERT INTO `vacaciones` VALUES (217, 219, 0x323031302d32303131, 13.5, 0x323031312d32303132, 15.0, 0x70616320616c2030392f30332f32303132);
INSERT INTO `vacaciones` VALUES (218, 220, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (219, 221, 0x323031302d32303131, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (220, 222, 0x323031302d32303131, 3.0, '', 0.0, 0x70616320616c2031352f30352f32303132202d206361732033302064696173);
INSERT INTO `vacaciones` VALUES (221, 223, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120666f726d2e207661632e206e69207061632e);
INSERT INTO `vacaciones` VALUES (222, 224, 0x323030392d32303130, 0.0, 0x323031302d32303131, 18.5, 0x50414320414c2032322f30332f323031322c20666f726d2e207661632e20616c2031382f30372f32303132);
INSERT INTO `vacaciones` VALUES (223, 225, 0x323031302d32303131, 9.0, 0x323031312d32303132, 15.0, 0x70616320616c2032302f30392f32303131);
INSERT INTO `vacaciones` VALUES (224, 226, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (225, 227, 0x323031312d32303132, 14.0, '', 0.0, 0x70616320616c2030392f30332f32303132);
INSERT INTO `vacaciones` VALUES (226, 228, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (227, 229, 0x323030392d32303130, 2.0, 0x323031302d32303131, 15.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (228, 230, 0x323031302d32303131, 14.0, 0x323031312d32303132, 30.0, 0x666f726d2e207661632e20616c2032392f30362f32303132);
INSERT INTO `vacaciones` VALUES (229, 231, 0x323031302d32303131, 15.0, '', 0.0, 0x666f726d2076616320616c2031392f31322f32303131);
INSERT INTO `vacaciones` VALUES (230, 232, 0x323031302d32303131, 0.5, 0x323031312d32303132, 15.0, 0x70616320616c2032382f30332f32303132);
INSERT INTO `vacaciones` VALUES (231, 233, 0x323031312d32303132, 23.0, '', 0.0, 0x70616320616c2030362f30362f32303132);
INSERT INTO `vacaciones` VALUES (232, 234, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (233, 235, 0x323031312d32303132, 15.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (234, 236, 0x323031302d32303131, 17.0, 0x323031312d32303132, 30.0, 0x666f726d2076616320616c2033302f30342f32303132206e6f2063617320656e2066696c652c206e6920656e20696e666f726d652c207665726966696361722033302064696173206465207661636163696f6e);
INSERT INTO `vacaciones` VALUES (235, 237, 0x323030392d32303130, 9.0, 0x323031302d32303131, 30.0, 0x666f726d2076616320616c2032352f30362f32303132);
INSERT INTO `vacaciones` VALUES (236, 238, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e);
INSERT INTO `vacaciones` VALUES (237, 239, 0x323031312d32303132, 8.0, '', 0.0, 0x666f726d2e207661632e2030322f30372f32303132);
INSERT INTO `vacaciones` VALUES (238, 240, 0x323031302d32303131, 8.0, 0x323031312d32303132, 15.0, 0x70616320616c2032372f30342f32303132);
INSERT INTO `vacaciones` VALUES (239, 241, 0x323031302d32303131, 0.0, 0x323031312d32303132, 18.0, 0x70616320616c2031392f30362f323031322c20464f524d205641432e20414c2031332f30382f32303132202d203235);
INSERT INTO `vacaciones` VALUES (240, 242, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e64656e207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (241, 243, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (242, 244, 0x323031302d32303131, 4.5, 0x323031312d32303132, 30.0, 0x70616320616c2031332f30362f323031322c20464f524d2e205641432e20414c2031332f30382f32303132);
INSERT INTO `vacaciones` VALUES (243, 245, 0x323031302d32303131, 0.5, 0x323031312d32303132, 15.0, 0x70616320616c2032342f30352f32303132);
INSERT INTO `vacaciones` VALUES (244, 246, 0x323031312d32303132, 14.0, '', 0.0, 0x70616320616c2030312f30362f32303132);
INSERT INTO `vacaciones` VALUES (245, 247, 0x323031302d32303131, 5.5, 0x323031312d32303132, 30.0, 0x70616320616c2031332f30342f32303132);
INSERT INTO `vacaciones` VALUES (246, 248, 0x323031302d32303131, 16.0, 0x323031312d32303132, 20.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (247, 249, 0x323031312d32303132, 15.5, '', 0.0, 0x666f726d2076616320616c2032392f30362f32303132);
INSERT INTO `vacaciones` VALUES (248, 250, 0x323031312d32303132, 20.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (249, 251, 0x323031302d32303131, 10.5, 0x323031312d32303132, 15.0, 0x50414320414c2030322f30352f32303132);
INSERT INTO `vacaciones` VALUES (250, 252, 0x323030392d32303130, 0.0, 0x323031302d32303131, 14.0, 0x70616320616c2032352f30352f32303132);
INSERT INTO `vacaciones` VALUES (251, 253, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (252, 254, 0x323031302d32303131, 30.0, 0x323031312d32303132, 30.0, 0x6e6f20726567697374726120666f726d2e207661632e206e69207061632061637475616c6573);
INSERT INTO `vacaciones` VALUES (253, 255, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (254, 256, 0x323031302d32303131, 21.5, 0x323031312d32303132, 30.0, 0x70616320616c2032362f30332f323031322c20464f524d2e205641432e20414c2030332f382f3230313220283529);
INSERT INTO `vacaciones` VALUES (255, 257, 0x323030392d32303130, 6.5, 0x323031302d32303131, 15.0, 0x70616320616c2031382f30342f32303132);
INSERT INTO `vacaciones` VALUES (256, 258, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (257, 259, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120666f726d2e207661632e206e69207061632e);
INSERT INTO `vacaciones` VALUES (258, 260, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (259, 261, 0x323031302d32303131, 11.5, 0x323031312d32303132, 15.0, 0x666f726d2076616320616c2032392f31322f32303131);
INSERT INTO `vacaciones` VALUES (260, 262, 0x323031302d32303131, 14.0, '', 0.0, 0x666f726d2076616320616c2032322f31322f32303131);
INSERT INTO `vacaciones` VALUES (261, 263, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e202d206e6f20636173);
INSERT INTO `vacaciones` VALUES (262, 264, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120666f726d20766163206e6920706163202d206e6f20636173);
INSERT INTO `vacaciones` VALUES (263, 265, 0x323031302d32303131, 27.0, 0x323031312d32303132, 30.0, 0x70616320616c2032322f30362f32303132);
INSERT INTO `vacaciones` VALUES (264, 266, 0x323030392d32303130, 11.0, 0x323031302d32303131, 15.0, 0x70616320616c2031352f30352f32303132);
INSERT INTO `vacaciones` VALUES (265, 267, 0x323031302d32303131, 26.0, 0x323031312d32303132, 30.0, 0x70616320616c2032332f30332f32303132);
INSERT INTO `vacaciones` VALUES (266, 268, 0x323031312d32303132, 11.5, '', 0.0, 0x6e6f20726567697374726120666f726d2e207661632e206e692070616320);
INSERT INTO `vacaciones` VALUES (267, 269, 0x323030382d32303039, 0.0, '', 0.0, 0x63657272616461732067657374696f6e657320323031302d32303131207920323031312d32303132);
INSERT INTO `vacaciones` VALUES (268, 270, 0x323031302d32303131, 29.0, 0x323031312d32303132, 30.0, 0x70616320616c2030382f30362f32303132202d20726576697361722066696c6520756e612076657a2071207675656c76612064652061756469746f72696120);
INSERT INTO `vacaciones` VALUES (269, 271, 0x323031302d32303131, 13.0, '', 0.0, 0x70616320616c2032372f31302f32303131);
INSERT INTO `vacaciones` VALUES (270, 272, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (271, 273, 0x323031302d32303131, 8.0, '', 0.0, 0x70616320616c2032302f30362f32303132);
INSERT INTO `vacaciones` VALUES (272, 274, 0x323030392d32303130, 15.0, 0x323031302d32303131, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (273, 275, 0x323030392d32303130, 17.5, 0x323031302d32303131, 30.0, 0x666f726d2e207661632e20616c2030372f30352f32303132);
INSERT INTO `vacaciones` VALUES (274, 276, 0x323031312d32303132, 11.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (275, 277, 0x323031302d32303131, 20.0, 0x323031312d32303132, 20.0, 0x666f726d207661632e20616c2031302f30352f32303131206361732066696c6520382061c3b16f732c206e6f2066696775726120656e20696e666f726d652063617320);
INSERT INTO `vacaciones` VALUES (276, 278, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (277, 279, 0x323031312d32303132, 14.0, '', 0.0, 0x6e6f20726567697374726120666f726d20766163206e6920706163);
INSERT INTO `vacaciones` VALUES (278, 280, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (279, 281, 0x323030392d32303130, 3.0, 0x323031302d32303131, 15.0, 0x70616320616c2032382f31302f32303131);
INSERT INTO `vacaciones` VALUES (280, 282, 0x323030392d32303130, 0.0, 0x323031302d32303131, 14.5, 0x70616320616c2033312f30352f323031322c20464f524d2e205641432c20414c2032352f30372f32303132);
INSERT INTO `vacaciones` VALUES (281, 283, 0x323031312d32303132, 15.0, '', 0.0, 0x70616320616c2031332f30362f32303132);
INSERT INTO `vacaciones` VALUES (282, 284, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (283, 285, 0x323031312d32303132, 15.0, '', 0.0, 0x6e6f20726567697374726120666f726d2e207661632e206e6920706163);
INSERT INTO `vacaciones` VALUES (284, 286, 0x323031312d32303132, 15.0, '', 0.0, 0x736520686162696c6974616e206c6f73203135206469617320656c2033312f30372f32303131);
INSERT INTO `vacaciones` VALUES (285, 287, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x70616320616c2032372f30332f32303132);
INSERT INTO `vacaciones` VALUES (286, 288, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (287, 289, 0x323031302d32303131, 25.5, 0x323031312d32303132, 30.0, 0x736567756e20696e666f726d65206361733e3d3130612c2070616320616c2031312f30362f32303132);
INSERT INTO `vacaciones` VALUES (288, 290, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120666f726d207661632e206e69207061632061637475616c6573);
INSERT INTO `vacaciones` VALUES (289, 291, 0x323031302d32303131, 4.0, 0x323031312d32303132, 15.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (290, 292, 0x323031302d32303131, 15.0, '', 0.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (291, 293, 0x323031302d32303131, 10.5, 0x323031312d32303132, 15.0, 0x7061636120616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (292, 294, 0x323031312d32303132, 8.5, '', 0.0, 0x70616320616c2032322f30332f323031322c2070616320616c2032332f30372f32303132);
INSERT INTO `vacaciones` VALUES (293, 295, 0x323031312d32303132, 15.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e65732c2072656369656e74656d656e74652067616e61646f73);
INSERT INTO `vacaciones` VALUES (294, 296, 0x323031302d32303131, 15.0, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120666f726d2e207661632e206e6920706163);
INSERT INTO `vacaciones` VALUES (295, 297, 0x323030392d32303130, 15.0, 0x323031302d32303131, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e);
INSERT INTO `vacaciones` VALUES (296, 298, 0x323031312d32303132, 30.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (297, 299, 0x323031312d32303132, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (298, 300, 0x323030392d32303130, 1.5, 0x323031302d32303131, 30.0, 0x70616320616c2031372f30352f32303132);
INSERT INTO `vacaciones` VALUES (299, 301, 0x323031312d32303132, 8.0, '', 0.0, 0x70616320616c2030362f30362f32303132);
INSERT INTO `vacaciones` VALUES (300, 302, 0x323031302d32303131, 25.0, 0x323031312d32303132, 30.0, 0x666f726d612076616320616c2031362f30312f323031322c20464f524d2e205641432e20414c2030392f30372f32303132202d203130);
INSERT INTO `vacaciones` VALUES (301, 303, 0x323031302d32303131, 24.0, 0x323031312d32303132, 30.0, 0x666f726d2e207661632e20616c2030382f30352f32303132);
INSERT INTO `vacaciones` VALUES (302, 304, 0x323031302d32303131, 12.5, 0x323031312d32303132, 15.0, 0x6e6f20726567697374726120706163206e6920666f726d2e207661632e2061637475616c6573206f2064656c2061c3b16f2032303132);
INSERT INTO `vacaciones` VALUES (303, 305, 0x323030392d32303130, 0.0, 0x323031302d32303131, 19.0, 0x70616320616c2032352f30352f323031322c20666f726d2e207661632e20616c2031332f30382f32303132);
INSERT INTO `vacaciones` VALUES (304, 306, 0x323031302d32303131, 25.0, 0x323031312d32303132, 30.0, 0x70616320616c2031352f30352f32303132);
INSERT INTO `vacaciones` VALUES (305, 307, 0x323030392d32303130, 0.0, 0x323031302d32303131, 27.0, 0x70616320616c2032352f30362f323031322c20666f726d2e2076616320616c2030332f30382f323031322028372e3520736f6c6f207669657220746172646529);
INSERT INTO `vacaciones` VALUES (306, 308, 0x323031302d32303131, 21.0, 0x323031312d32303132, 30.0, 0x70616320616c20303830362f323031322c20666f726d2e207661632e2031322f30372f32303132);
INSERT INTO `vacaciones` VALUES (307, 309, 0x323031302d32303131, 7.0, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (308, 310, 0x323031302d32303131, 6.5, '', 0.0, 0x70616320616c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (309, 311, 0x323031302d32303131, 21.0, 0x323031312d32303132, 30.0, 0x70616320616c2031302f30352f3132202d6e6f2063617320656e20696e666f726d65207065726f20736920656e2066696c652c20464f524d2e205641432e20414c2030322f30372f32303132202d2035);
INSERT INTO `vacaciones` VALUES (310, 312, 0x323030392d32303130, 2.5, 0x323031302d32303131, 30.0, 0x666f726d2e207661632e20616c2030322f30372f3230313220);
INSERT INTO `vacaciones` VALUES (311, 313, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (312, 314, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (313, 315, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (314, 316, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (315, 317, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (316, 318, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (317, 319, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (318, 320, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (319, 321, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (320, 322, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (321, 323, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (322, 324, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (323, 325, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (324, 326, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (325, 327, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (326, 328, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (327, 329, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e657320);
INSERT INTO `vacaciones` VALUES (328, 330, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e657320);
INSERT INTO `vacaciones` VALUES (329, 331, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (330, 332, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (331, 333, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (332, 334, 0x323031302d32303131, 0.0, 0x323031312d32303132, 28.0, '');
INSERT INTO `vacaciones` VALUES (333, 335, 0x323031302d32303131, 19.0, 0x323031312d32303132, 20.0, 0x70616320616c2030382f30362f323031322c2067616e6f203230206469617320656c2031362f30372f32303132);
INSERT INTO `vacaciones` VALUES (334, 336, 0x323031302d32303131, 1.0, 0x323031312d32303132, 15.0, 0x666f726d2076616320616c2033302f30352f32303132);
INSERT INTO `vacaciones` VALUES (335, 337, 0x323030392d32303130, 0.0, 0x323031302d32303131, 0.0, 0x666f726d2e207661632e20616c2030332f30312f32303132202d20656e2061676f73746f2072656369656e2067616e6172612033302064696173);
INSERT INTO `vacaciones` VALUES (336, 338, 0x323031302d32303131, 11.0, 0x323031312d32303132, 15.0, 0x756c74696d6f20666f726d2e207661632e20616c2032372f31322f323031302c2067616e6f20323031312d32303132203d20656e2031382f30362f32303132);
INSERT INTO `vacaciones` VALUES (337, 339, 0x323031302d32303131, 0.0, 0x323031312d32303132, 8.5, 0x70616320616c2031382f30362f32303132);
INSERT INTO `vacaciones` VALUES (338, 340, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465207661636163696f6e6573);
INSERT INTO `vacaciones` VALUES (339, 341, 0x323031322d32303133, 0.0, '', 0.0, 0x41554e204e4f20434f52524553504f4e4445205641434143494f4e4553);
INSERT INTO `vacaciones` VALUES (340, 342, 0x323031322d32303133, 0.0, '', 0.0, 0x41554e204e4f20434f52524553504f4e4445);
INSERT INTO `vacaciones` VALUES (341, 343, 0x323031312d32303132, 11.0, '', 0.0, 0x50414320414c2030382f30362f32303132);
INSERT INTO `vacaciones` VALUES (342, 344, 0x323031322d32303133, 0.0, '', 0.0, 0x61756e206e6f20636f72726573706f6e6465);
INSERT INTO `vacaciones` VALUES (343, 345, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (344, 346, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (345, 347, 0x323030392d32303130, 0.0, 0x323031302d32303131, 21.0, 0x70616320616c2030332f30372f323031322c20464f524d2056414320414c2032372f30372f32303132202d2036);
INSERT INTO `vacaciones` VALUES (346, 348, 0x323031302d32303131, 13.0, 0x323031312d32303132, 15.0, 0x6e6f206361732c2061206c612066656368612030372f30382066696c6520656e2061756469746f72696120696e7465726e61);
INSERT INTO `vacaciones` VALUES (347, 349, 0x323031312d32303132, 15.0, '', 0.0, 0x4e4f20524547495354524120464f524d2e205641432e204e49205041432e20);
INSERT INTO `vacaciones` VALUES (348, 350, 0x323031322d32303133, 0.0, '', 0.0, 0x41554e204e4f20434f52524553504f4e4445);
INSERT INTO `vacaciones` VALUES (349, 351, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (350, 352, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (351, 353, 0x323031302d32303131, 12.0, 0x323031312d32303132, 15.0, 0x504143532e20534f4c414d454e5445204155442e20494e542e);
INSERT INTO `vacaciones` VALUES (352, 354, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (353, 355, 0x323031322d32303133, 0.0, '', 0.0, '');
INSERT INTO `vacaciones` VALUES (354, 356, 0x323031322d32303133, 0.0, '', 0.0, '');
