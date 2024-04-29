CREATE DATABASE  IF NOT EXISTS `ingresodocentes`;
USE `ingresodocentes`;

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE `docentes` (
  `ci` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `olvido` tinyint(1) DEFAULT '0',
  `estado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ingresos`;
CREATE TABLE `ingresos` (
  `fecha` date NOT NULL,
  `Docentes_ci` int(11) NOT NULL,
  `hora` time NOT NULL,
  `observacion` varchar(50) DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`fecha`,`Docentes_ci`,`hora`),
  KEY `fk_Ingresos_Docentes_idx` (`Docentes_ci`),
  CONSTRAINT `fk_Ingresos_Docentes` FOREIGN KEY (`Docentes_ci`) REFERENCES `docentes` (`ci`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
