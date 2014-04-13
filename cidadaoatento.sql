/*
 * Copyright (C) 2014 Pedro Maia (pedro@pedromm.com)
 *
 * This file is part of Cidadão Atento.
 * 
 * Cidadão Atento is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Cidadão Atento is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Cidadão Atento.  If not, see <http://www.gnu.org/licenses/>.
 */

-- MySQL dump 10.13  Distrib 5.1.49, for pc-linux-gnu (i686)
--
-- Host: 10.7.26.22    Database: cidadaoatento
-- ------------------------------------------------------
-- Server version	5.5.25-log
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_apoios`
--

DROP TABLE IF EXISTS `tbl_apoios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_apoios` (
  `codigo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do apoio.',
  `tbl_denuncias_codigo` bigint(20) unsigned NOT NULL COMMENT 'Denúncia referente ao apoio.',
  `tbl_cidadaos_cpf` bigint(20) unsigned NOT NULL COMMENT 'CPF referente ao apoio.',
  `data` datetime DEFAULT NULL COMMENT 'Data em que foi registrado.',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_apoios_tbl_denuncias_idx` (`tbl_denuncias_codigo`),
  KEY `fk_tbl_apoios_tbl_cidadaos_idx` (`tbl_cidadaos_cpf`),
  CONSTRAINT `fk_tbl_apoios_tbl_cidadaos` FOREIGN KEY (`tbl_cidadaos_cpf`) REFERENCES `tbl_cidadaos` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_apoios_tbl_denuncias` FOREIGN KEY (`tbl_denuncias_codigo`) REFERENCES `tbl_denuncias` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_apoios`
--

LOCK TABLES `tbl_apoios` WRITE;
/*!40000 ALTER TABLE `tbl_apoios` DISABLE KEYS */;
INSERT INTO `tbl_apoios` VALUES (1,10,94342186403,'2012-09-12 06:09:03'),(2,19,9043271675,'2012-10-05 03:10:53'),(3,21,9498295603,'2012-10-05 06:10:44'),(4,22,9498295603,'2012-10-05 06:10:19'),(5,23,30475361636,'2012-10-07 03:10:01');
/*!40000 ALTER TABLE `tbl_apoios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_avisos`
--

DROP TABLE IF EXISTS `tbl_avisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_avisos` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do aviso',
  `aviso` text NOT NULL COMMENT 'Conteúdo do aviso.',
  `data_add` datetime NOT NULL COMMENT 'Data em que foi adicionado',
  `periodo` tinyint(4) NOT NULL COMMENT 'Quantidade de dias para exibir o aviso',
  `tipo` tinyint(4) NOT NULL COMMENT 'Define a gravidade do aviso',
  `tbl_moderadores_codigo` smallint(5) unsigned NOT NULL COMMENT 'Define quem criou o aviso',
  `interno` char(1) DEFAULT 'N' COMMENT 'Define se vai exibir para o modulo Interno',
  `sup` char(1) DEFAULT 'N' COMMENT 'Define se vai exibir para o modulo SUP',
  `suo` char(1) DEFAULT 'N' COMMENT 'Define se vai exibir para o modulo SUO',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_avisos_tbl_moderadores1_idx` (`tbl_moderadores_codigo`),
  CONSTRAINT `fk_tbl_avisos_tbl_moderadores1` FOREIGN KEY (`tbl_moderadores_codigo`) REFERENCES `tbl_moderadores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_avisos`
--

LOCK TABLES `tbl_avisos` WRITE;
/*!40000 ALTER TABLE `tbl_avisos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_avisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_blog`
--

DROP TABLE IF EXISTS `tbl_blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_blog` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do post',
  `titulo` varchar(45) NOT NULL COMMENT 'Título do post',
  `post` text NOT NULL COMMENT 'Conteúdo do post',
  `data_add` datetime DEFAULT NULL COMMENT 'Data em que ele foi postado',
  `tbl_moderadores_codigo` smallint(5) unsigned DEFAULT NULL COMMENT 'Moderador que enviou a publicação',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_blog_tbl_moderadores_idx` (`tbl_moderadores_codigo`),
  CONSTRAINT `fk_tbl_blog_tbl_moderadores` FOREIGN KEY (`tbl_moderadores_codigo`) REFERENCES `tbl_moderadores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_blog`
--

LOCK TABLES `tbl_blog` WRITE;
/*!40000 ALTER TABLE `tbl_blog` DISABLE KEYS */;
INSERT INTO `tbl_blog` VALUES (1,'Sobre o projeto','O cidadaoatento.com é um projeto aberto à participação de todos os brasileiros.\n\nO principal objetivo é transmitir ao governo municipal, de uma forma fácil e dinâmica, os problemas relacionados à infraestrutura e más condições das estradas, constantemente questionadas pelos cidadãos.\n\nCada pessoa com CPF válido pode relatar problemas em sua região, como buracos, vias, falta de semáforos e quebra-molas, vazamentos, iluminação pública defeituosa, coleta seletiva ineficiente, entre outros.','2012-09-30 02:36:02',1),(2,'Jornal Ehjovem','Estamos no jornal Ehjovem que circula em Nova Lima e Raposos!\n\nhttp://issuu.com/ehjovem/docs/eh_jovem_-_009_-_tb31','2012-10-03 06:59:05',1);
/*!40000 ALTER TABLE `tbl_blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cidadaos`
--

DROP TABLE IF EXISTS `tbl_cidadaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cidadaos` (
  `cpf` bigint(20) unsigned NOT NULL COMMENT 'CPF do cidadão',
  `telefone` bigint(20) unsigned NOT NULL COMMENT 'Telefone do cidadão',
  `data_add` datetime NOT NULL COMMENT 'Data da sua primeira denúncia',
  `ultimo_login` datetime NOT NULL COMMENT 'Última vez que o cidadão utilizou o sistema',
  `ultimo_ip` varchar(45) NOT NULL COMMENT 'Último IP que o cidadão utilizou para acessar o sistema',
  `num_denuncias` int(10) unsigned DEFAULT '0' COMMENT 'Conta o número de denúncias',
  `num_apoios` int(10) unsigned DEFAULT '0' COMMENT 'Conta o número de apoios',
  `num_reportes` int(10) unsigned DEFAULT '0' COMMENT 'Conta o número de reportes',
  `bloqueado` char(1) DEFAULT 'N' COMMENT 'Define se a conta está bloqueada',
  `token_in` varchar(255) DEFAULT NULL COMMENT 'Token de segurança privada',
  `token_out` varchar(255) DEFAULT NULL COMMENT 'Token de segurança pública',
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `UNIQUE` (`cpf`,`telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_denuncias`
--

DROP TABLE IF EXISTS `tbl_denuncias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_denuncias` (
  `codigo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código da denuncia',
  `ip` varchar(45) NOT NULL COMMENT 'IP do cidadão',
  `lat` float NOT NULL COMMENT 'Latitude da denúncia',
  `lng` float NOT NULL COMMENT 'Longitude da denúncia',
  `foto` varchar(100) DEFAULT NULL COMMENT 'Foto da denúncia',
  `data_add` datetime DEFAULT NULL COMMENT 'Data na qual a denúncia foi registrada',
  `data_solu` datetime DEFAULT NULL COMMENT 'Data na qual a denúncia foi solucionada',
  `invalido` char(1) DEFAULT 'N' COMMENT 'Define se a denúncia é inválida',
  `solucionado` char(1) DEFAULT 'N' COMMENT 'Define se a denúncia foi solucionada',
  `tbl_tipo_problemas_codigo` smallint(5) unsigned DEFAULT NULL COMMENT 'Define o tipo de problema relatado',
  `tbl_prefeituras_codigo` bigint(20) unsigned DEFAULT NULL COMMENT 'Define qual prefeitura está relacionado.',
  `tbl_cidadaos_cpf` bigint(20) unsigned DEFAULT NULL COMMENT 'Cidadão que registrou a denúncia',
  `descricao` varchar(100) NOT NULL COMMENT 'Descrição sobre o problema relacionado a denúncia.',
  `numero_apoios` int(10) unsigned DEFAULT '0' COMMENT 'Número de apoios recebidos',
  `verificada` char(1) DEFAULT 'N' COMMENT 'Define se a denúncia foi verificada por algum moderador',
  `endereco` varchar(255) DEFAULT NULL COMMENT 'Endereço da denúncia',
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `foto_UNIQUE` (`foto`),
  KEY `fk_tbl_denuncias_tbl_tipo_problemas_idx` (`tbl_tipo_problemas_codigo`),
  KEY `fk_tbl_denuncias_tbl_prefeituras_idx` (`tbl_prefeituras_codigo`),
  KEY `fk_tbl_denuncias_tbl_cidadaos_idx` (`tbl_cidadaos_cpf`),
  CONSTRAINT `fk_tbl_denuncias_tbl_cidadaos` FOREIGN KEY (`tbl_cidadaos_cpf`) REFERENCES `tbl_cidadaos` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_denuncias_tbl_prefeituras` FOREIGN KEY (`tbl_prefeituras_codigo`) REFERENCES `tbl_prefeituras` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_denuncias_tbl_tipo_problemas` FOREIGN KEY (`tbl_tipo_problemas_codigo`) REFERENCES `tbl_tipo_problemas` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_moderadores`
--

DROP TABLE IF EXISTS `tbl_moderadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_moderadores` (
  `codigo` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do moderador',
  `nome` varchar(100) NOT NULL COMMENT 'Nome do moderador',
  `email` varchar(255) NOT NULL COMMENT 'Email do moderador',
  `senha` varchar(255) NOT NULL COMMENT 'Senha do moderador',
  `data_add` datetime NOT NULL COMMENT 'Data na qual o moderador foi adicionado',
  `ultimo_login` datetime DEFAULT NULL COMMENT 'Última vez em que o moderador acessou o sistema',
  `ultimo_ip` varchar(45) DEFAULT NULL COMMENT 'Último IP que o moderador utilizou para acessar o sistema',
  `habilitado` char(1) DEFAULT 'S' COMMENT 'Define se o moderador está possui acesso ao sistema',
  `avisos` char(1) DEFAULT 'S' COMMENT 'Define se o moderador quer receber avisos no e-mail.',
  `relatorios` char(1) DEFAULT 'S' COMMENT 'Define se o moderador quer receber relatórios no e-mail.',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_orgaos`
--

DROP TABLE IF EXISTS `tbl_orgaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_orgaos` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do orgão',
  `nome` varchar(45) NOT NULL COMMENT 'Nome do orgão',
  `sigla` varchar(10) NOT NULL COMMENT 'Sigla do orgão',
  `email` varchar(255) NOT NULL COMMENT 'Email do orgão para envio de relatórios e/ou avisos',
  `minimo_apoios` int(10) unsigned DEFAULT '100' COMMENT 'Minímo de apoios necessários para disparo do email',
  `senha` varchar(255) NOT NULL COMMENT 'Senha para login no SUO',
  `ultimo_login` datetime DEFAULT NULL COMMENT 'Data do último login',
  `ultimo_ip` varchar(45) DEFAULT NULL COMMENT 'IP utilizado no último login',
  `avisos` char(1) DEFAULT 'S' COMMENT 'Define se o orgão aceita avisos.',
  `relatorios` char(1) DEFAULT 'S' COMMENT 'Define se o orgão aceita relatórios',
  `habilitado` char(1) DEFAULT 'S' COMMENT 'Define se o orgão está habilitado',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_prefeituras`
--

DROP TABLE IF EXISTS `tbl_prefeituras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_prefeituras` (
  `codigo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código da prefeitura',
  `municipio` varchar(50) NOT NULL DEFAULT 'N/A' COMMENT 'Município referente a prefeitura',
  `uf` char(2) NOT NULL COMMENT 'Estado referente a prefeitura',
  `senha` varchar(255) NOT NULL COMMENT 'Senha de acesso ao sistema',
  `ultimo_login` datetime NOT NULL COMMENT 'Última vez em que a prefeitura acessou o sistema',
  `ultimo_ip` varchar(45) NOT NULL COMMENT 'Último IP que a prefeitura utilizou para acessar o sistema',
  `habilitado` char(1) DEFAULT 'S' COMMENT 'Define se a prefeitura está habilitada para usar o sistema',
  `email` varchar(255) DEFAULT NULL COMMENT 'Define o email da prefeitura para avisos e/ou relatórios',
  `avisos` char(1) DEFAULT 'S' COMMENT 'Define se a prefeitura aceita avisos.',
  `relatorios` char(1) DEFAULT 'S' COMMENT 'Define se a prefeitura aceita relatórios',
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_reportes`
--

DROP TABLE IF EXISTS `tbl_reportes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reportes` (
  `codigo` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Codigo do reporte',
  `ip` varchar(45) NOT NULL COMMENT 'IP do cidadão que reportou',
  `data_add` datetime NOT NULL COMMENT 'Data na qual o reporte foi adicionado',
  `data_solu` datetime DEFAULT NULL COMMENT 'Data na qual o reporte foi checado',
  `solucionado` char(1) DEFAULT 'N' COMMENT 'Define se o reporte foi solucionado',
  `tbl_moderadores_codigo` smallint(5) unsigned DEFAULT NULL COMMENT 'Código do moderador que cuidou do reporte',
  `tbl_denuncias_codigo` bigint(20) unsigned DEFAULT NULL COMMENT 'Código da denuncia que foi reportada',
  `tbl_cidadaos_cpf` bigint(20) unsigned NOT NULL COMMENT 'Define o cidadão que criou o reporte',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_reportes_tbl_moderadores_idx` (`tbl_moderadores_codigo`),
  KEY `fk_tbl_reportes_tbl_denuncias_idx` (`tbl_denuncias_codigo`),
  KEY `fk_tbl_reportes_tbl_cidadaos1_idx` (`tbl_cidadaos_cpf`),
  CONSTRAINT `fk_tbl_reportes_tbl_cidadaos1` FOREIGN KEY (`tbl_cidadaos_cpf`) REFERENCES `tbl_cidadaos` (`cpf`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_reportes_tbl_denuncias` FOREIGN KEY (`tbl_denuncias_codigo`) REFERENCES `tbl_denuncias` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_reportes_tbl_moderadores` FOREIGN KEY (`tbl_moderadores_codigo`) REFERENCES `tbl_moderadores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_respostas`
--

DROP TABLE IF EXISTS `tbl_respostas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_respostas` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código da reposta',
  `resposta` text COMMENT 'Conteúdo da resposta',
  `data_add` datetime DEFAULT NULL COMMENT 'Data na qual foi adicionada',
  `tbl_tickets_codigo` int(10) unsigned DEFAULT NULL COMMENT 'Define o ticket na qual está relacionada',
  `tbl_moderadores_codigo` smallint(5) unsigned zerofill DEFAULT NULL COMMENT 'Define quem respondeu',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_respostas_tbl_tickets_idx` (`tbl_tickets_codigo`),
  KEY `fk_tbl_respostas_tbl_moderadores_idx` (`tbl_moderadores_codigo`),
  CONSTRAINT `fk_tbl_respostas_tbl_moderadores` FOREIGN KEY (`tbl_moderadores_codigo`) REFERENCES `tbl_moderadores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_respostas_tbl_tickets` FOREIGN KEY (`tbl_tickets_codigo`) REFERENCES `tbl_tickets` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tickets`
--

DROP TABLE IF EXISTS `tbl_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tickets` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código do ticket',
  `nome` varchar(45) NOT NULL COMMENT 'Nome do cidadão',
  `email` varchar(255) NOT NULL COMMENT 'E-mail do cidadão',
  `data_add` datetime DEFAULT NULL COMMENT 'Data em que foi adicionado',
  `data_solu` datetime DEFAULT NULL COMMENT 'Data em que foi solucionado',
  `assunto` varchar(45) NOT NULL COMMENT 'Assunto do ticket',
  `texto` text NOT NULL COMMENT 'Text do ticket',
  `aberto` char(1) DEFAULT 'S' COMMENT 'Define se o ticket está em aberto',
  `tbl_moderadores_codigo` smallint(5) unsigned zerofill DEFAULT NULL COMMENT 'Define o moderador que está atuando sobre o ticket',
  PRIMARY KEY (`codigo`),
  KEY `fk_tbl_tickets_tbl_moderadores1_idx` (`tbl_moderadores_codigo`),
  CONSTRAINT `fk_tbl_tickets_tbl_moderadores1` FOREIGN KEY (`tbl_moderadores_codigo`) REFERENCES `tbl_moderadores` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_tipo_problemas`
--

DROP TABLE IF EXISTS `tbl_tipo_problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_tipo_problemas` (
  `codigo` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Código',
  `descricao` varchar(45) NOT NULL COMMENT 'Descrição do tipo de problema',
  `img` varchar(100) NOT NULL COMMENT 'Icone do tipo de problema',
  `tbl_orgaos_codigo` int(10) unsigned NOT NULL COMMENT 'Define o orgão atuante',
  PRIMARY KEY (`codigo`),
  KEY `problemas_tbl_orgaos_idx` (`tbl_orgaos_codigo`),
  CONSTRAINT `problemas_tbl_orgaos` FOREIGN KEY (`tbl_orgaos_codigo`) REFERENCES `tbl_orgaos` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_tipo_problemas`
--

LOCK TABLES `tbl_tipo_problemas` WRITE;
/*!40000 ALTER TABLE `tbl_tipo_problemas` DISABLE KEYS */;
INSERT INTO `tbl_tipo_problemas` VALUES (1,'Buracos','97467e772c6f18164ac0830e27521a7g.png',1),(2,'Tampa de esgoto','97467e772c6f18164ac0830e27521a7c.png',1),(3,'Falta de poda em árvore','f0118de505437a6cfb74d10c300bf3eb.png',1),(4,'Falta de Iluminação','1105af124677eae463a52508b6c0965b.png',1),(5,'Problema de Trânsito','57c798f83d90db0674c8707d0774fb5d.png',1),(7,'Poluição Sonora','efe7173aebea6eb911ca7cf1d012a89b.png',1),(8,'Obras Inacabadas','d39765ae902be530f9375998d1a81de5.png',1);
/*!40000 ALTER TABLE `tbl_tipo_problemas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'cidadaoatento'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-08  9:57:36
