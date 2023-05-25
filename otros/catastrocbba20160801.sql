CREATE DATABASE  IF NOT EXISTS `catastrocbba` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `catastrocbba`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 192.168.114.100    Database: catastrocbba
-- ------------------------------------------------------
-- Server version	5.6.22-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `avaluo`
--

DROP TABLE IF EXISTS `avaluo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avaluo` (
  `idAvaluo` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `numeroHabilitado` int(11) NOT NULL,
  `estadoAvaluo` int(11) NOT NULL,
  `fechaAvaluo` datetime DEFAULT NULL,
  `estadoImpresion` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `fechaImpresion` datetime DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  `superficiePredio` decimal(10,2) NOT NULL,
  `superficieBloques` decimal(10,2) DEFAULT NULL,
  `superficieMejoras` decimal(10,2) DEFAULT NULL,
  `valorTerreno` decimal(10,2) NOT NULL,
  `valorBloques` decimal(10,2) DEFAULT NULL,
  `valorMejoras` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idAvaluo`),
  KEY `fk_avaluo_usuario_idx` (`idUsuario`),
  CONSTRAINT `fk_avaluo_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla principal de avaluo de un predio';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaluo`
--

LOCK TABLES `avaluo` WRITE;
/*!40000 ALTER TABLE `avaluo` DISABLE KEYS */;
/*!40000 ALTER TABLE `avaluo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bloques_dato`
--

DROP TABLE IF EXISTS `bloques_dato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bloques_dato` (
  `idBloqueDato` int(11) NOT NULL AUTO_INCREMENT,
  `idPredio` int(11) NOT NULL,
  `numerobloque` varchar(10) NOT NULL,
  `superficieBloque` decimal(10,2) NOT NULL,
  `anioConstruccion` int(11) NOT NULL,
  `cantidadPisos` int(11) NOT NULL,
  `idCoeficienteUso` int(11) NOT NULL,
  `idCoeficienteDepreciacion` int(11) NOT NULL,
  `observaciones` mediumtext,
  `tipoBloque` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idBloqueDato`),
  KEY `fk_bloqueDato_predioDato_idx` (`idPredio`),
  KEY `fk_bloqueDato_coefDepreciacion_idx` (`idCoeficienteDepreciacion`),
  KEY `fk_bloqueDato_coefUso_idx` (`idCoeficienteUso`),
  CONSTRAINT `fk_bloqueDato_coefDepre` FOREIGN KEY (`idCoeficienteDepreciacion`) REFERENCES `coeficiente_depreciacion` (`idCoeficienteDepreciacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bloqueDato_coefUso` FOREIGN KEY (`idCoeficienteUso`) REFERENCES `coeficiente_uso` (`idCoeficienteUso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bloqueDato_predio` FOREIGN KEY (`idPredio`) REFERENCES `predio` (`idPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bloques_dato`
--

LOCK TABLES `bloques_dato` WRITE;
/*!40000 ALTER TABLE `bloques_dato` DISABLE KEYS */;
/*!40000 ALTER TABLE `bloques_dato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `caracteristicas_bloque`
--

DROP TABLE IF EXISTS `caracteristicas_bloque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `caracteristicas_bloque` (
  `idCaracteristicaBloque` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoCaracteristica` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idCaracteristicaBloque`),
  KEY `fk_CaracBloque_tipoCarac_idx` (`idTipoCaracteristica`),
  CONSTRAINT `fk_CaracBloque_tipoCarac` FOREIGN KEY (`idTipoCaracteristica`) REFERENCES `tipo_caracteristicas` (`idTipoCaracteristica`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `caracteristicas_bloque`
--

LOCK TABLES `caracteristicas_bloque` WRITE;
/*!40000 ALTER TABLE `caracteristicas_bloque` DISABLE KEYS */;
/*!40000 ALTER TABLE `caracteristicas_bloque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coeficiente_depreciacion`
--

DROP TABLE IF EXISTS `coeficiente_depreciacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coeficiente_depreciacion` (
  `idCoeficienteDepreciacion` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficienteBloque` decimal(10,3) NOT NULL,
  `coeficienteMejora` decimal(10,3) DEFAULT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idCoeficienteDepreciacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coeficiente_depreciacion`
--

LOCK TABLES `coeficiente_depreciacion` WRITE;
/*!40000 ALTER TABLE `coeficiente_depreciacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `coeficiente_depreciacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coeficiente_topografico`
--

DROP TABLE IF EXISTS `coeficiente_topografico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coeficiente_topografico` (
  `idCoeficienteTopografico` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idCoeficienteTopografico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coeficiente_topografico`
--

LOCK TABLES `coeficiente_topografico` WRITE;
/*!40000 ALTER TABLE `coeficiente_topografico` DISABLE KEYS */;
/*!40000 ALTER TABLE `coeficiente_topografico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coeficiente_uso`
--

DROP TABLE IF EXISTS `coeficiente_uso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coeficiente_uso` (
  `idCoeficienteUso` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idCoeficienteUso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coeficiente_uso`
--

LOCK TABLES `coeficiente_uso` WRITE;
/*!40000 ALTER TABLE `coeficiente_uso` DISABLE KEYS */;
/*!40000 ALTER TABLE `coeficiente_uso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datos_propietario`
--

DROP TABLE IF EXISTS `datos_propietario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `datos_propietario` (
  `idDatosPropietario` int(11) NOT NULL AUTO_INCREMENT,
  `idPredio` int(11) NOT NULL,
  `apellidoUno` varchar(200) NOT NULL,
  `apellidoDos` varchar(50) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `numeroDocumento` varchar(20) DEFAULT NULL,
  `idEmitidoEn` int(11) DEFAULT NULL,
  `numeroNIT` varchar(20) DEFAULT NULL,
  `porcentaje` decimal(5,2) DEFAULT NULL,
  `matricula` varchar(21) DEFAULT NULL,
  `asiento` int(11) DEFAULT NULL,
  `fojas` int(11) DEFAULT NULL,
  `partida` int(11) DEFAULT NULL,
  `fechaTestimonio` datetime DEFAULT NULL,
  `numeroTestimonio` int(11) DEFAULT NULL,
  `fechaRegistroDDRR` datetime DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idDatosPropietario`),
  KEY `fk_datosProp_Predio_idx` (`idPredio`),
  CONSTRAINT `fk_datosProp_predio` FOREIGN KEY (`idPredio`) REFERENCES `predio` (`idPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_propietario`
--

LOCK TABLES `datos_propietario` WRITE;
/*!40000 ALTER TABLE `datos_propietario` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_propietario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forma_predio`
--

DROP TABLE IF EXISTS `forma_predio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forma_predio` (
  `idFormaPredio` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idFormaPredio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forma_predio`
--

LOCK TABLES `forma_predio` WRITE;
/*!40000 ALTER TABLE `forma_predio` DISABLE KEYS */;
/*!40000 ALTER TABLE `forma_predio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imagen_predio`
--

DROP TABLE IF EXISTS `imagen_predio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagen_predio` (
  `idImagenPredio` int(11) NOT NULL AUTO_INCREMENT,
  `idPredio` int(11) NOT NULL,
  `imagen` longtext NOT NULL,
  `idRelacion` int(11) NOT NULL,
  `tipoRelacion` varchar(1) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idImagenPredio`),
  KEY `fk_imagen_predio_idx` (`idPredio`),
  CONSTRAINT `fk_imagen_predio` FOREIGN KEY (`idPredio`) REFERENCES `predio` (`idPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imagen_predio`
--

LOCK TABLES `imagen_predio` WRITE;
/*!40000 ALTER TABLE `imagen_predio` DISABLE KEYS */;
/*!40000 ALTER TABLE `imagen_predio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_via`
--

DROP TABLE IF EXISTS `material_via`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material_via` (
  `idMaterialVia` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idMaterialVia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_via`
--

LOCK TABLES `material_via` WRITE;
/*!40000 ALTER TABLE `material_via` DISABLE KEYS */;
/*!40000 ALTER TABLE `material_via` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mejora_dato`
--

DROP TABLE IF EXISTS `mejora_dato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mejora_dato` (
  `idMejorasDato` int(11) NOT NULL AUTO_INCREMENT,
  `idPredio` int(11) NOT NULL,
  `idTipoMejora` int(11) NOT NULL,
  `superficie` decimal(10,2) NOT NULL,
  `anioConstruccion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idMejorasDato`),
  KEY `fk_mejoraDato_predio_idx` (`idPredio`),
  KEY `fk_mejoraDato_tipoMejora_idx` (`idTipoMejora`),
  CONSTRAINT `fk_mejoraDato_predio` FOREIGN KEY (`idPredio`) REFERENCES `predio` (`idPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mejoraDato_tipoMejora` FOREIGN KEY (`idTipoMejora`) REFERENCES `tipo_mejora` (`idTipoMejora`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mejora_dato`
--

LOCK TABLES `mejora_dato` WRITE;
/*!40000 ALTER TABLE `mejora_dato` DISABLE KEYS */;
/*!40000 ALTER TABLE `mejora_dato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel_predio`
--

DROP TABLE IF EXISTS `nivel_predio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nivel_predio` (
  `idNivelPredio` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idNivelPredio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel_predio`
--

LOCK TABLES `nivel_predio` WRITE;
/*!40000 ALTER TABLE `nivel_predio` DISABLE KEYS */;
/*!40000 ALTER TABLE `nivel_predio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predio`
--

DROP TABLE IF EXISTS `predio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predio` (
  `idPredio` int(11) NOT NULL AUTO_INCREMENT,
  `codigoSubDistrito` int(11) NOT NULL,
  `codigoManzana` int(11) NOT NULL,
  `codigoPredio` int(11) NOT NULL,
  `codigoUso` int(11) NOT NULL,
  `codigoBloque` int(11) DEFAULT NULL,
  `codigoPlanta` int(11) DEFAULT NULL,
  `codigoUnidad` int(11) DEFAULT NULL,
  `numeroInmueble` double DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `numeroPuerta` varchar(20) NOT NULL,
  `nombreEdificio` varchar(50) DEFAULT NULL,
  `piso` varchar(45) DEFAULT NULL,
  `planta` varchar(45) DEFAULT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL,
  `codigoCatastral` varchar(20) NOT NULL,
  `goecodigo` varchar(50) DEFAULT NULL,
  `idAvaluo` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idPredio`),
  KEY `fk_predio_avaluo_idx` (`idAvaluo`),
  CONSTRAINT `fk_predio_avaluo` FOREIGN KEY (`idAvaluo`) REFERENCES `avaluo` (`idAvaluo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin5 COMMENT='Tabla principal de predios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predio`
--

LOCK TABLES `predio` WRITE;
/*!40000 ALTER TABLE `predio` DISABLE KEYS */;
/*!40000 ALTER TABLE `predio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predio_dato`
--

DROP TABLE IF EXISTS `predio_dato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predio_dato` (
  `idPredioDato` int(11) NOT NULL AUTO_INCREMENT,
  `idPredio` int(11) NOT NULL,
  `idCoeficienteTopografico` int(11) NOT NULL,
  `idZonaHomogenea` int(11) NOT NULL,
  `idFormaPredio` int(11) NOT NULL,
  `idUbicacionPredio` int(11) NOT NULL,
  `idMaterialVia` int(11) NOT NULL,
  `idNivelPredio` int(11) NOT NULL,
  `frentePredio` decimal(10,2) NOT NULL,
  `fondoPredio` decimal(10,2) DEFAULT NULL,
  `superficieAprobada` decimal(10,2) DEFAULT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idPredioDato`),
  KEY `fk_predioDato_coefTopo_idx` (`idCoeficienteTopografico`),
  KEY `fk_predioDatos_Predio_idx` (`idPredio`),
  KEY `fk_predioDato_ubicacion_idx` (`idUbicacionPredio`),
  KEY `fk_predioDato_forma_idx` (`idFormaPredio`),
  KEY `fk_predioDato_materialVia_idx` (`idMaterialVia`),
  KEY `fk_predioDato_nivel_idx` (`idNivelPredio`),
  KEY `fk_predioDato_zonaHomo_idx` (`idZonaHomogenea`),
  CONSTRAINT `fk_predioDato_coeftopo` FOREIGN KEY (`idCoeficienteTopografico`) REFERENCES `coeficiente_topografico` (`idCoeficienteTopografico`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_forma` FOREIGN KEY (`idFormaPredio`) REFERENCES `forma_predio` (`idFormaPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_materialVia` FOREIGN KEY (`idMaterialVia`) REFERENCES `material_via` (`idMaterialVia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_nivel` FOREIGN KEY (`idNivelPredio`) REFERENCES `nivel_predio` (`idNivelPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_predio` FOREIGN KEY (`idPredio`) REFERENCES `predio` (`idPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_ubicacion` FOREIGN KEY (`idUbicacionPredio`) REFERENCES `ubicacion_predio` (`idUbicacionPredio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioDato_zonaHomo` FOREIGN KEY (`idZonaHomogenea`) REFERENCES `zona_homogenea` (`idZonaHomogenea`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predio_dato`
--

LOCK TABLES `predio_dato` WRITE;
/*!40000 ALTER TABLE `predio_dato` DISABLE KEYS */;
/*!40000 ALTER TABLE `predio_dato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `predio_servicio`
--

DROP TABLE IF EXISTS `predio_servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `predio_servicio` (
  `idPredioServicio` int(11) NOT NULL AUTO_INCREMENT,
  `idServicio` int(11) NOT NULL,
  `idPredioDato` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idPredioServicio`),
  KEY `fk_predioServicio_Servicio_idx` (`idServicio`),
  KEY `fk_predioServicio_PredioDato_idx` (`idPredioDato`),
  CONSTRAINT `fk_predioServicio_predioDatos` FOREIGN KEY (`idPredioDato`) REFERENCES `predio_dato` (`idPredioDato`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_predioServicio_servicios` FOREIGN KEY (`idServicio`) REFERENCES `servicio` (`idServicio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `predio_servicio`
--

LOCK TABLES `predio_servicio` WRITE;
/*!40000 ALTER TABLE `predio_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `predio_servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio`
--

DROP TABLE IF EXISTS `servicio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idServicio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio`
--

LOCK TABLES `servicio` WRITE;
/*!40000 ALTER TABLE `servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `servicio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_caracteristicas`
--

DROP TABLE IF EXISTS `tipo_caracteristicas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_caracteristicas` (
  `idTipoCaracteristica` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idTipoCaracteristica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_caracteristicas`
--

LOCK TABLES `tipo_caracteristicas` WRITE;
/*!40000 ALTER TABLE `tipo_caracteristicas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_caracteristicas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_mejora`
--

DROP TABLE IF EXISTS `tipo_mejora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_mejora` (
  `idTipoMejora` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idTipoMejora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_mejora`
--

LOCK TABLES `tipo_mejora` WRITE;
/*!40000 ALTER TABLE `tipo_mejora` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_mejora` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicacion_predio`
--

DROP TABLE IF EXISTS `ubicacion_predio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ubicacion_predio` (
  `idUbicacionPredio` int(11) NOT NULL AUTO_INCREMENT,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `coeficiente` decimal(10,2) NOT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idUbicacionPredio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion_predio`
--

LOCK TABLES `ubicacion_predio` WRITE;
/*!40000 ALTER TABLE `ubicacion_predio` DISABLE KEYS */;
/*!40000 ALTER TABLE `ubicacion_predio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(40) NOT NULL,
  `contrasenia` varchar(40) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `numeroDocumento` varchar(40) NOT NULL,
  `numeroRegistro` varchar(40) NOT NULL,
  `tipoUsuario` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `email` mediumtext NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `valores_bloque`
--

DROP TABLE IF EXISTS `valores_bloque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `valores_bloque` (
  `idValorBloque` int(11) NOT NULL AUTO_INCREMENT,
  `idBloqueDato` int(11) NOT NULL,
  `idCaracteristicaBloque` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `porcentaje` float NOT NULL,
  `puntaje` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idValorBloque`),
  KEY `fk_valoresBloque_BloqueDato_idx` (`idBloqueDato`),
  KEY `fk_valoresbloque_caracteristicaBloque_idx` (`idCaracteristicaBloque`),
  CONSTRAINT `fk_ValorBloque_bloqueDato` FOREIGN KEY (`idBloqueDato`) REFERENCES `bloques_dato` (`idBloqueDato`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ValorBloque_caracBloque` FOREIGN KEY (`idCaracteristicaBloque`) REFERENCES `caracteristicas_bloque` (`idCaracteristicaBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `valores_bloque`
--

LOCK TABLES `valores_bloque` WRITE;
/*!40000 ALTER TABLE `valores_bloque` DISABLE KEYS */;
/*!40000 ALTER TABLE `valores_bloque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zona_homogenea`
--

DROP TABLE IF EXISTS `zona_homogenea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zona_homogenea` (
  `idZonaHomogenea` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `codigoZona` int(11) NOT NULL,
  `valorCatastralM2` decimal(10,2) NOT NULL,
  `valorCatastralM2PH` decimal(10,2) DEFAULT NULL,
  `gestion` int(11) NOT NULL,
  `estado` varchar(2) NOT NULL,
  PRIMARY KEY (`idZonaHomogenea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zona_homogenea`
--

LOCK TABLES `zona_homogenea` WRITE;
/*!40000 ALTER TABLE `zona_homogenea` DISABLE KEYS */;
/*!40000 ALTER TABLE `zona_homogenea` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-08-01 16:37:15
