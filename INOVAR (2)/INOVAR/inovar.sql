-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           10.4.32-MariaDB - mariadb.org binary distribution
-- SO do servidor:               Win64
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- A despejar estrutura da base de dados para escola
CREATE DATABASE IF NOT EXISTS `escola` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `escola`;

-- A despejar estrutura para tabela escola.alunos
CREATE TABLE IF NOT EXISTS `alunos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `turma` varchar(100) NOT NULL,
  `nif` varchar(15) NOT NULL,
  `nascimento` date NOT NULL,
  `nacionalidade` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `morada` varchar(255) NOT NULL,
  `avatar` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.alunos: ~2 rows (aproximadamente)
INSERT INTO `alunos` (`id`, `nome`, `senha`, `turma`, `nif`, `nascimento`, `nacionalidade`, `email`, `morada`, `avatar`) VALUES
	(1, 'caio paraiso', '1234', 'tis7', '111111111', '2005-02-22', 'Africano', 'africano@gmail.com', 'Africa', 'https://www.zerozero.pt/img/jogadores/new/54/84/1155484_caio_paraiso_20240806124843.jpg'),
	(8, 'sseses', '1234', 'tis8', '1111', '6666-05-04', 'sxzsasas', 'dada@sas', 'sasas', 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg');

-- A despejar estrutura para tabela escola.bloqueios
CREATE TABLE IF NOT EXISTS `bloqueios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia_semana` varchar(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.bloqueios: ~0 rows (aproximadamente)
INSERT INTO `bloqueios` (`id`, `dia_semana`, `hora_inicio`, `hora_fim`) VALUES
	(1, 'sexta', '18:33:00', '18:32:00');

-- A despejar estrutura para tabela escola.candidaturas
CREATE TABLE IF NOT EXISTS `candidaturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `data_nascimento` date NOT NULL,
  `curso` varchar(50) DEFAULT NULL,
  `documento_identificacao` longblob DEFAULT NULL,
  `certificado_habilitacoes` longblob DEFAULT NULL,
  `boletim_vacinas` longblob DEFAULT NULL,
  `foto1` longblob DEFAULT NULL,
  `foto2` longblob DEFAULT NULL,
  `comprovativo_iban` longblob DEFAULT NULL,
  `atestado_residencia` longblob DEFAULT NULL,
  `declaracao_centro_emprego` longblob DEFAULT NULL,
  `data_submissao` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.candidaturas: ~2 rows (aproximadamente)
INSERT INTO `candidaturas` (`id`, `nome`, `email`, `telefone`, `data_nascimento`, `curso`, `documento_identificacao`, `certificado_habilitacoes`, `boletim_vacinas`, `foto1`, `foto2`, `comprovativo_iban`, `atestado_residencia`, `declaracao_centro_emprego`, `data_submissao`) VALUES
	(8, 'sseses', 'adada@dada', '111111', '2006-02-16', 'TIS', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', '2024-11-07 22:02:27'),
	(9, 'sseses', 'adada@dada', '111111', '2006-02-16', 'TIS', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', '2024-11-07 22:02:39'),
	(10, 'wwqwq', 'a@dadada', '999999999', '1999-02-16', '', _binary '', NULL, _binary '', _binary '', _binary '', _binary '', _binary '', _binary '', '2024-11-16 21:36:21');

-- A despejar estrutura para tabela escola.curso
CREATE TABLE IF NOT EXISTS `curso` (
  `id_curso` bigint(20) NOT NULL,
  `sigla` varchar(5) DEFAULT NULL,
  `nome` varchar(250) DEFAULT NULL,
  `ufcd_id` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.curso: ~3 rows (aproximadamente)
INSERT INTO `curso` (`id_curso`, `sigla`, `nome`, `ufcd_id`) VALUES
	(1, 'TIS', 'Tecnico de Informatica - Sistemas', NULL),
	(2, 'TIGR', 'Tecnico Informatica - Gestao de Redes', NULL),
	(3, 'TM', 'Tecnico de Multimédia', NULL);

-- A despejar estrutura para tabela escola.curso_ufcd
CREATE TABLE IF NOT EXISTS `curso_ufcd` (
  `id_curso_ufcd` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` bigint(20) DEFAULT NULL,
  `ufcd_id` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`id_curso_ufcd`),
  KEY `cursoufcd_curso` (`curso_id`),
  KEY `cursoufcd_ufcds` (`ufcd_id`),
  CONSTRAINT `cursoufcd_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cursoufcd_ufcds` FOREIGN KEY (`ufcd_id`) REFERENCES `ufcds` (`ufcd`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.curso_ufcd: ~4 rows (aproximadamente)
INSERT INTO `curso_ufcd` (`id_curso_ufcd`, `curso_id`, `ufcd_id`) VALUES
	(25, 3, '749'),
	(26, 3, '754'),
	(28, 3, '328'),
	(29, 1, '749');

-- A despejar estrutura para tabela escola.disponiblidade
CREATE TABLE IF NOT EXISTS `disponiblidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `professor` int(11) NOT NULL,
  `2b1` tinyint(1) DEFAULT 0,
  `2b2` tinyint(1) DEFAULT 0,
  `2b3` tinyint(1) DEFAULT 0,
  `2b4` tinyint(1) DEFAULT 0,
  `3b1` tinyint(1) DEFAULT 0,
  `3b2` tinyint(1) DEFAULT 0,
  `3b3` tinyint(1) DEFAULT 0,
  `3b4` tinyint(1) DEFAULT 0,
  `4b1` tinyint(1) DEFAULT 0,
  `4b2` tinyint(1) DEFAULT 0,
  `4b3` tinyint(1) DEFAULT 0,
  `4b4` tinyint(1) DEFAULT 0,
  `5b1` tinyint(1) DEFAULT 0,
  `5b2` tinyint(1) DEFAULT 0,
  `5b3` tinyint(1) DEFAULT 0,
  `5b4` tinyint(1) DEFAULT 0,
  `6b1` tinyint(1) DEFAULT 0,
  `6b2` tinyint(1) DEFAULT 0,
  `6b3` tinyint(1) DEFAULT 0,
  `6b4` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `professor` (`professor`),
  CONSTRAINT `disponiblidade_ibfk_1` FOREIGN KEY (`professor`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.disponiblidade: ~23 rows (aproximadamente)
INSERT INTO `disponiblidade` (`id`, `professor`, `2b1`, `2b2`, `2b3`, `2b4`, `3b1`, `3b2`, `3b3`, `3b4`, `4b1`, `4b2`, `4b3`, `4b4`, `5b1`, `5b2`, `5b3`, `5b4`, `6b1`, `6b2`, `6b3`, `6b4`) VALUES
	(1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(6, 6, 0, 1, 1, 1, 0, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
	(7, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(8, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(9, 9, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0),
	(10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(11, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(12, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(13, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(14, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(15, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(16, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(17, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(18, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(19, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(20, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(21, 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(22, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
	(23, 23, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- A despejar estrutura para tabela escola.sala
CREATE TABLE IF NOT EXISTS `sala` (
  `id_sala` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(2) DEFAULT NULL,
  `pc` tinyint(1) DEFAULT NULL,
  `office` tinyint(1) DEFAULT NULL,
  `adobe` tinyint(1) DEFAULT NULL,
  `VM` tinyint(1) DEFAULT NULL,
  `VSCODE` tinyint(1) DEFAULT NULL,
  `projetor` tinyint(1) DEFAULT NULL,
  `local` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.sala: ~9 rows (aproximadamente)
INSERT INTO `sala` (`id_sala`, `nome`, `pc`, `office`, `adobe`, `VM`, `VSCODE`, `projetor`, `local`) VALUES
	(1, 'E1', 1, 1, 1, 1, 1, 1, 'principal'),
	(2, 'E2', 1, 1, 0, 1, 1, 1, 'principal'),
	(3, 'E3', 1, 1, 0, 1, 1, 1, 'principal'),
	(4, 'E4', 0, 0, 0, 0, 0, 1, 'principal'),
	(5, 'E5', 1, 1, 0, 1, 1, 1, 'principal'),
	(6, 'A1', 1, 1, 1, 0, 0, 1, 'secundaria'),
	(7, 'A2', 1, 1, 1, 0, 0, 1, 'secundaria'),
	(8, 'A3', 1, 1, 1, 0, 0, 1, 'secundaria'),
	(9, 'A', 0, 0, 0, 0, 0, 0, 'principal');

-- A despejar estrutura para tabela escola.tis7
CREATE TABLE IF NOT EXISTS `tis7` (
  `ufcd` varchar(10) NOT NULL,
  `professor` varchar(100) NOT NULL,
  `concluida` int(11) NOT NULL,
  PRIMARY KEY (`ufcd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis7: ~3 rows (aproximadamente)
INSERT INTO `tis7` (`ufcd`, `professor`, `concluida`) VALUES
	('0754', 'vasco salada', 0),
	('0755', 'vasco salada', 0),
	('0757', 'carlos cruz', 0);

-- A despejar estrutura para tabela escola.tis7_horario
CREATE TABLE IF NOT EXISTS `tis7_horario` (
  `b1_seg_ufcd` int(11) DEFAULT NULL,
  `b1_seg_sala` int(11) DEFAULT NULL,
  `b2_seg_ufcd` int(11) DEFAULT NULL,
  `b2_seg_sala` int(11) DEFAULT NULL,
  `b3_seg_ufcd` int(11) DEFAULT NULL,
  `b3_seg_sala` int(11) DEFAULT NULL,
  `b4_seg_ufcd` int(11) DEFAULT NULL,
  `b4_seg_sala` int(11) DEFAULT NULL,
  `b1_ter_ufcd` int(11) DEFAULT NULL,
  `b1_ter_sala` int(11) DEFAULT NULL,
  `b2_ter_ufcd` int(11) DEFAULT NULL,
  `b2_ter_sala` int(11) DEFAULT NULL,
  `b3_ter_ufcd` int(11) DEFAULT NULL,
  `b3_ter_sala` int(11) DEFAULT NULL,
  `b4_ter_ufcd` int(11) DEFAULT NULL,
  `b4_ter_sala` int(11) DEFAULT NULL,
  `b1_qua_ufcd` int(11) DEFAULT NULL,
  `b1_qua_sala` int(11) DEFAULT NULL,
  `b2_qua_ufcd` int(11) DEFAULT NULL,
  `b2_qua_sala` int(11) DEFAULT NULL,
  `b3_qua_ufcd` int(11) DEFAULT NULL,
  `b3_qua_sala` int(11) DEFAULT NULL,
  `b4_qua_ufcd` int(11) DEFAULT NULL,
  `b4_qua_sala` int(11) DEFAULT NULL,
  `b1_qui_ufcd` int(11) DEFAULT NULL,
  `b1_qui_sala` int(11) DEFAULT NULL,
  `b2_qui_ufcd` int(11) DEFAULT NULL,
  `b2_qui_sala` int(11) DEFAULT NULL,
  `b3_qui_ufcd` int(11) DEFAULT NULL,
  `b3_qui_sala` int(11) DEFAULT NULL,
  `b4_qui_ufcd` int(11) DEFAULT NULL,
  `b4_qui_sala` int(11) DEFAULT NULL,
  `b1_sex_ufcd` int(11) DEFAULT NULL,
  `b1_sex_sala` int(11) DEFAULT NULL,
  `b2_sex_ufcd` int(11) DEFAULT NULL,
  `b2_sex_sala` int(11) DEFAULT NULL,
  `b3_sex_ufcd` int(11) DEFAULT NULL,
  `b3_sex_sala` int(11) DEFAULT NULL,
  `b4_sex_ufcd` int(11) DEFAULT NULL,
  `b4_sex_sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis7_horario: ~0 rows (aproximadamente)
INSERT INTO `tis7_horario` (`b1_seg_ufcd`, `b1_seg_sala`, `b2_seg_ufcd`, `b2_seg_sala`, `b3_seg_ufcd`, `b3_seg_sala`, `b4_seg_ufcd`, `b4_seg_sala`, `b1_ter_ufcd`, `b1_ter_sala`, `b2_ter_ufcd`, `b2_ter_sala`, `b3_ter_ufcd`, `b3_ter_sala`, `b4_ter_ufcd`, `b4_ter_sala`, `b1_qua_ufcd`, `b1_qua_sala`, `b2_qua_ufcd`, `b2_qua_sala`, `b3_qua_ufcd`, `b3_qua_sala`, `b4_qua_ufcd`, `b4_qua_sala`, `b1_qui_ufcd`, `b1_qui_sala`, `b2_qui_ufcd`, `b2_qui_sala`, `b3_qui_ufcd`, `b3_qui_sala`, `b4_qui_ufcd`, `b4_qui_sala`, `b1_sex_ufcd`, `b1_sex_sala`, `b2_sex_ufcd`, `b2_sex_sala`, `b3_sex_ufcd`, `b3_sex_sala`, `b4_sex_ufcd`, `b4_sex_sala`) VALUES
	(754, 7, 773, 2, 846, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- A despejar estrutura para tabela escola.tis7_notas
CREATE TABLE IF NOT EXISTS `tis7_notas` (
  `nome` varchar(250) DEFAULT NULL,
  `0754` int(2) DEFAULT NULL,
  `0769` int(2) DEFAULT NULL,
  `0770` int(2) DEFAULT NULL,
  `0771` int(2) DEFAULT NULL,
  `0772` int(2) DEFAULT NULL,
  `0773` int(2) DEFAULT NULL,
  `0774` int(2) DEFAULT NULL,
  `0775` int(2) DEFAULT NULL,
  `0776` int(2) DEFAULT NULL,
  `0778` int(2) DEFAULT NULL,
  `0780` int(2) DEFAULT NULL,
  `0781` int(2) DEFAULT NULL,
  `0782` int(2) DEFAULT NULL,
  `0783` int(2) DEFAULT NULL,
  `0784` int(2) DEFAULT NULL,
  `0785` int(2) DEFAULT NULL,
  `0789` int(2) DEFAULT NULL,
  `0779` int(2) DEFAULT NULL,
  `0786` int(2) DEFAULT NULL,
  `0787` int(2) DEFAULT NULL,
  `0788` int(2) DEFAULT NULL,
  `0791` int(2) DEFAULT NULL,
  `0792` int(2) DEFAULT NULL,
  `0793` int(2) DEFAULT NULL,
  `10791` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis7_notas: ~0 rows (aproximadamente)
INSERT INTO `tis7_notas` (`nome`, `0754`, `0769`, `0770`, `0771`, `0772`, `0773`, `0774`, `0775`, `0776`, `0778`, `0780`, `0781`, `0782`, `0783`, `0784`, `0785`, `0789`, `0779`, `0786`, `0787`, `0788`, `0791`, `0792`, `0793`, `10791`) VALUES
	('caio paraiso', 19, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- A despejar estrutura para tabela escola.tis8
CREATE TABLE IF NOT EXISTS `tis8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  `professor` varchar(100) NOT NULL,
  `concluida` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis8: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela escola.tis8_horario
CREATE TABLE IF NOT EXISTS `tis8_horario` (
  `b1_seg_ufcd` int(11) DEFAULT NULL,
  `b1_seg_sala` int(11) DEFAULT NULL,
  `b2_seg_ufcd` int(11) DEFAULT NULL,
  `b2_seg_sala` int(11) DEFAULT NULL,
  `b3_seg_ufcd` int(11) DEFAULT NULL,
  `b3_seg_sala` int(11) DEFAULT NULL,
  `b4_seg_ufcd` int(11) DEFAULT NULL,
  `b4_seg_sala` int(11) DEFAULT NULL,
  `b1_ter_ufcd` int(11) DEFAULT NULL,
  `b1_ter_sala` int(11) DEFAULT NULL,
  `b2_ter_ufcd` int(11) DEFAULT NULL,
  `b2_ter_sala` int(11) DEFAULT NULL,
  `b3_ter_ufcd` int(11) DEFAULT NULL,
  `b3_ter_sala` int(11) DEFAULT NULL,
  `b4_ter_ufcd` int(11) DEFAULT NULL,
  `b4_ter_sala` int(11) DEFAULT NULL,
  `b1_qua_ufcd` int(11) DEFAULT NULL,
  `b1_qua_sala` int(11) DEFAULT NULL,
  `b2_qua_ufcd` int(11) DEFAULT NULL,
  `b2_qua_sala` int(11) DEFAULT NULL,
  `b3_qua_ufcd` int(11) DEFAULT NULL,
  `b3_qua_sala` int(11) DEFAULT NULL,
  `b4_qua_ufcd` int(11) DEFAULT NULL,
  `b4_qua_sala` int(11) DEFAULT NULL,
  `b1_qui_ufcd` int(11) DEFAULT NULL,
  `b1_qui_sala` int(11) DEFAULT NULL,
  `b2_qui_ufcd` int(11) DEFAULT NULL,
  `b2_qui_sala` int(11) DEFAULT NULL,
  `b3_qui_ufcd` int(11) DEFAULT NULL,
  `b3_qui_sala` int(11) DEFAULT NULL,
  `b4_qui_ufcd` int(11) DEFAULT NULL,
  `b4_qui_sala` int(11) DEFAULT NULL,
  `b1_sex_ufcd` int(11) DEFAULT NULL,
  `b1_sex_sala` int(11) DEFAULT NULL,
  `b2_sex_ufcd` int(11) DEFAULT NULL,
  `b2_sex_sala` int(11) DEFAULT NULL,
  `b3_sex_ufcd` int(11) DEFAULT NULL,
  `b3_sex_sala` int(11) DEFAULT NULL,
  `b4_sex_ufcd` int(11) DEFAULT NULL,
  `b4_sex_sala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis8_horario: ~0 rows (aproximadamente)
INSERT INTO `tis8_horario` (`b1_seg_ufcd`, `b1_seg_sala`, `b2_seg_ufcd`, `b2_seg_sala`, `b3_seg_ufcd`, `b3_seg_sala`, `b4_seg_ufcd`, `b4_seg_sala`, `b1_ter_ufcd`, `b1_ter_sala`, `b2_ter_ufcd`, `b2_ter_sala`, `b3_ter_ufcd`, `b3_ter_sala`, `b4_ter_ufcd`, `b4_ter_sala`, `b1_qua_ufcd`, `b1_qua_sala`, `b2_qua_ufcd`, `b2_qua_sala`, `b3_qua_ufcd`, `b3_qua_sala`, `b4_qua_ufcd`, `b4_qua_sala`, `b1_qui_ufcd`, `b1_qui_sala`, `b2_qui_ufcd`, `b2_qui_sala`, `b3_qui_ufcd`, `b3_qui_sala`, `b4_qui_ufcd`, `b4_qui_sala`, `b1_sex_ufcd`, `b1_sex_sala`, `b2_sex_ufcd`, `b2_sex_sala`, `b3_sex_ufcd`, `b3_sex_sala`, `b4_sex_ufcd`, `b4_sex_sala`) VALUES
	(9958, 4, 6714, 1, 3, 7, 6, 7, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 7, 0, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- A despejar estrutura para tabela escola.tis8_notas
CREATE TABLE IF NOT EXISTS `tis8_notas` (
  `nome` varchar(250) DEFAULT NULL,
  `0754` int(2) DEFAULT NULL,
  `0769` int(2) DEFAULT NULL,
  `0770` int(2) DEFAULT NULL,
  `0771` int(2) DEFAULT NULL,
  `0772` int(2) DEFAULT NULL,
  `0773` int(2) DEFAULT NULL,
  `0774` int(2) DEFAULT NULL,
  `0775` int(2) DEFAULT NULL,
  `0776` int(2) DEFAULT NULL,
  `0778` int(2) DEFAULT NULL,
  `0780` int(2) DEFAULT NULL,
  `0781` int(2) DEFAULT NULL,
  `0782` int(2) DEFAULT NULL,
  `0783` int(2) DEFAULT NULL,
  `0784` int(2) DEFAULT NULL,
  `0785` int(2) DEFAULT NULL,
  `0789` int(2) DEFAULT NULL,
  `0779` int(2) DEFAULT NULL,
  `0786` int(2) DEFAULT NULL,
  `0787` int(2) DEFAULT NULL,
  `0788` int(2) DEFAULT NULL,
  `0791` int(2) DEFAULT NULL,
  `0792` int(2) DEFAULT NULL,
  `0793` int(2) DEFAULT NULL,
  `10791` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.tis8_notas: ~0 rows (aproximadamente)

-- A despejar estrutura para tabela escola.turmas
CREATE TABLE IF NOT EXISTS `turmas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `inicio` int(11) NOT NULL DEFAULT 0,
  `fim` int(11) DEFAULT NULL,
  `curso` varchar(255) DEFAULT NULL,
  `professor` varchar(255) NOT NULL,
  `sigla` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.turmas: ~2 rows (aproximadamente)
INSERT INTO `turmas` (`id`, `nome`, `inicio`, `fim`, `curso`, `professor`, `sigla`) VALUES
	(1, 'tis7', 2022, 2025, 'Tecnico de Informática', '9', 1),
	(26, 'tis8', 2023, 2026, 'Tecnico de Informática', '17', 1);

-- A despejar estrutura para tabela escola.ufcd
CREATE TABLE IF NOT EXISTS `ufcd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` varchar(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `horas` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.ufcd: ~23 rows (aproximadamente)
INSERT INTO `ufcd` (`id`, `numero`, `nome`, `horas`) VALUES
	(23, '0754', 'Processador de texto', 50),
	(24, '0769', 'Arquitetura interna do computador', 25),
	(25, '0770', 'Dispositivos e Periféricos', 25),
	(26, '0771', 'Conexões de rede', 25),
	(27, '0772', 'Sistemas operativos – instalação e configuração', 25),
	(28, '0773', 'Rede Local - instalação', 25),
	(29, '0774', 'Rede Local - instalação de software base', 50),
	(30, '0775', 'Rede local – administração', 50),
	(31, '0776', 'Sistema de informação da empresa', 25),
	(32, '0778', 'Folha de cálculo', 50),
	(33, '0780', 'Aplicações de gestão administrativa', 50),
	(34, '0781', 'Análise de sistemas de informação', 50),
	(35, '0782', 'Programação em C/C++ - estrutura básica e conceitos fundamentais', 50),
	(36, '0783', 'Programação em C/C++ - ciclos e decisões', 50),
	(37, '0784', 'Programação em C/C++ - funções e estruturas', 50),
	(38, '10791', 'Desenvolvimento de aplicações web em JAVA', 50),
	(39, '0793', 'Scripts CGI e folhas de estilo', 50),
	(40, '0792', 'Criação de páginas para a web em hipertexto', 50),
	(41, '0791', 'Programação em JAVA - avançada', 50),
	(42, '0790', 'Instalação e administração de servidores WEB', 50),
	(43, '0787', 'Administração de bases de dados', 50),
	(44, '0786', 'Instalação de bases de dados', 50),
	(45, '0785', 'Programação em C/C++: formas complexas', 50);

-- A despejar estrutura para tabela escola.ufcds
CREATE TABLE IF NOT EXISTS `ufcds` (
  `ufcd` varchar(6) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `horas` int(11) DEFAULT NULL,
  `periodo` int(11) NOT NULL,
  `componente` varchar(100) NOT NULL,
  `dominio` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pc` tinyint(1) DEFAULT NULL,
  `office` tinyint(1) DEFAULT NULL,
  `adobe` tinyint(1) DEFAULT NULL,
  `vm` tinyint(1) DEFAULT NULL,
  `vscode` tinyint(1) DEFAULT NULL,
  `projetor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ufcd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- A despejar dados para tabela escola.ufcds: ~117 rows (aproximadamente)
INSERT INTO `ufcds` (`ufcd`, `nome`, `horas`, `periodo`, `componente`, `dominio`, `created_at`, `updated_at`, `pc`, `office`, `adobe`, `vm`, `vscode`, `projetor`) VALUES
	('0161', 'Execução do produto multimédia final', 50, 3, 'Tecnológica', '', '2024-11-07 00:39:12', '2024-11-07 00:39:12', 0, 0, 0, 0, 0, 0),
	('0328', 'Comunicação interpessoal e institucional', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:20:02', '2024-11-07 00:20:02', NULL, NULL, NULL, NULL, NULL, NULL),
	('0749', 'Arquitetura de computadores', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:33:25', '2024-11-06 23:33:25', NULL, NULL, NULL, NULL, NULL, NULL),
	('0754', 'Processador de Texto', 50, 1, 'Tecnológica', '', '2024-11-06 22:44:24', '2024-11-06 22:44:24', 1, 1, 0, 0, 0, 1),
	('0755', 'Processador de Texto - funcionalidades avançadas', 25, 1, 'Sociocultural', 'Tecnologias de informação e comunicação', '2024-11-06 22:22:39', '2024-11-06 22:31:19', 1, 1, 0, 0, 0, 1),
	('0757', 'Folha de cálculo - funcionalidades avançadas', 25, 2, 'Sociocultural', 'Tecnologias de informação e comunicação', '2024-11-06 22:36:30', '2024-11-06 22:36:30', NULL, NULL, NULL, NULL, NULL, NULL),
	('0767', 'Internet - navegação', 25, 1, 'Sociocultural', 'Tecnologias de informação e comunicação', '2024-11-06 22:32:26', '2024-11-06 22:32:26', NULL, NULL, NULL, NULL, NULL, NULL),
	('0769', 'Arquitetura interna do computador', 25, 1, 'Tecnológica', NULL, '2024-11-06 22:44:43', '2024-11-06 22:44:43', NULL, NULL, NULL, NULL, NULL, NULL),
	('0770', 'Dispositivos e periféricos', 25, 1, 'Tecnológica', NULL, '2024-11-06 22:45:02', '2024-11-06 22:45:02', NULL, NULL, NULL, NULL, NULL, NULL),
	('0771', 'Conexões de rede', 25, 1, 'Tecnológica', '', '2024-11-06 22:45:20', '2024-11-06 22:45:20', 1, 0, 0, 1, 1, 1),
	('0772', 'Sistemas operativos - instalação e configuração', 25, 1, 'Tecnológica', '', '2024-11-06 22:45:38', '2024-11-06 22:45:38', 1, 0, 0, 1, 1, 1),
	('0773', 'Rede local - instalação', 25, 1, 'Tecnológica', '', '2024-11-06 22:46:18', '2024-11-06 22:46:18', 1, 0, 0, 1, 1, 1),
	('0774', 'Rede local - instalação de software base', 50, 1, 'Tecnológica', '', '2024-11-06 22:46:48', '2024-11-06 22:46:48', 1, 0, 0, 1, 1, 1),
	('0775', 'Rede local - administração', 50, 1, 'Tecnológica', '', '2024-11-06 22:47:06', '2024-11-06 22:47:06', 1, 0, 0, 1, 1, 1),
	('0776', 'Sistema de informação da empresa', 25, 1, 'Tecnológica', '', '2024-11-06 22:47:25', '2024-11-06 22:47:25', 1, 0, 0, 1, 1, 1),
	('0778', 'Folha de Cálculo', 50, 1, 'Tecnológica', '', '2024-11-06 22:47:40', '2024-11-06 22:47:40', 1, 1, 0, 0, 0, 1),
	('0779', 'Utilitário de apresentação gráfica', 25, 3, 'Tecnológica', NULL, '2024-11-06 22:51:01', '2024-11-06 22:51:01', NULL, NULL, NULL, NULL, NULL, NULL),
	('0780', 'Aplicações de gestão administrativa', 50, 1, 'Tecnológica', NULL, '2024-11-06 22:47:56', '2024-11-06 22:47:56', NULL, NULL, NULL, NULL, NULL, NULL),
	('0781', 'Análise de sistemas de informação', 50, 2, 'Tecnológica', NULL, '2024-11-06 22:48:19', '2024-11-06 22:48:19', NULL, NULL, NULL, NULL, NULL, NULL),
	('0782', 'Programação em C/C++ - estrutura básica e conceitos fundamentais', 50, 2, 'Tecnológica', '', '2024-11-06 22:48:40', '2024-11-06 22:48:40', 1, 0, 0, 0, 1, 1),
	('0783', 'Programação em C/C++ - ciclos e decisões', 50, 2, 'Tecnológica', '', '2024-11-06 22:49:00', '2024-11-06 22:49:00', 1, 0, 0, 0, 1, 1),
	('0784', 'Programação em C/C++ - funções e estruturas', 50, 2, 'Tecnológica', '', '2024-11-06 22:49:25', '2024-11-06 22:49:25', 1, 0, 0, 0, 1, 1),
	('0785', 'Programação em C/C++ - formas complexas', 50, 2, 'Tecnológica', '', '2024-11-06 22:49:48', '2024-11-06 22:49:48', 1, 0, 0, 0, 1, 1),
	('0786', 'Instalação e configuração de sistemas de configuração de base de dados', 50, 3, 'Tecnológica', '', '2024-11-06 22:51:29', '2024-11-06 22:51:29', 1, 0, 0, 1, 1, 1),
	('0787', 'Administração de base de dados', 50, 3, 'Tecnológica', NULL, '2024-11-06 22:51:47', '2024-11-06 22:51:47', NULL, NULL, NULL, NULL, NULL, NULL),
	('0788', 'Instalação e administração de servidores WEB', 50, 3, 'Tecnológica', NULL, '2024-11-06 22:52:05', '2024-11-06 22:52:05', NULL, NULL, NULL, NULL, NULL, NULL),
	('0789', 'Fundamentos de linguagem JAVA', 50, 2, 'Tecnológica', NULL, '2024-11-06 22:50:42', '2024-11-06 22:50:42', NULL, NULL, NULL, NULL, NULL, NULL),
	('0791', 'Programação em JAVA - avançada', 50, 3, 'Tecnológica', NULL, '2024-11-06 22:52:24', '2024-11-06 22:52:24', NULL, NULL, NULL, NULL, NULL, NULL),
	('0792', 'Criação de páginas para a web em hipertexto', 25, 3, 'Sociocultural', 'Tecnologias de informação e comunicação', '2024-11-06 22:36:49', '2024-11-06 22:36:49', NULL, NULL, NULL, NULL, NULL, NULL),
	('0793', 'Scripts CGI e folhas de estilo', 25, 3, 'Tecnológica', NULL, '2024-11-06 22:52:40', '2024-11-06 22:52:40', NULL, NULL, NULL, NULL, NULL, NULL),
	('0822', 'Gestão e organização da informação', 25, 1, 'Tecnológica', NULL, '2024-11-06 23:34:14', '2024-11-06 23:34:14', NULL, NULL, NULL, NULL, NULL, NULL),
	('0823', 'Sistema operativo - plataformas', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:34:35', '2024-11-06 23:34:35', NULL, NULL, NULL, NULL, NULL, NULL),
	('0824', 'Sistema operativo - Distribuições Linux (Fedora, Debian, Suse...)', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:35:10', '2024-11-06 23:35:10', NULL, NULL, NULL, NULL, NULL, NULL),
	('0825', 'Tipologias de redes', 25, 1, 'Tecnológica', NULL, '2024-11-06 23:35:29', '2024-11-06 23:35:29', NULL, NULL, NULL, NULL, NULL, NULL),
	('0826', 'Redes - instalação e configuração', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:35:51', '2024-11-06 23:35:51', NULL, NULL, NULL, NULL, NULL, NULL),
	('0827', 'Protocolos de redes - instalação e configuração', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:36:16', '2024-11-06 23:36:16', NULL, NULL, NULL, NULL, NULL, NULL),
	('0828', 'Protocolos de redes - instalação e configuração em sistema Linux', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:36:43', '2024-11-06 23:36:43', NULL, NULL, NULL, NULL, NULL, NULL),
	('0829', 'Topologias de redes', 25, 1, 'Tecnológica', NULL, '2024-11-06 23:53:08', '2024-11-06 23:53:08', NULL, NULL, NULL, NULL, NULL, NULL),
	('0830', 'Topologias de redes - fibra ótica e wireless', 25, 1, 'Tecnológica', NULL, '2024-11-06 23:53:32', '2024-11-06 23:53:32', NULL, NULL, NULL, NULL, NULL, NULL),
	('0831', 'Topologias de redes - Ethernet, Token Ring', 25, 1, 'Tecnológica', NULL, '2024-11-06 23:53:56', '2024-11-06 23:53:56', NULL, NULL, NULL, NULL, NULL, NULL),
	('0832', 'Equipamentos passivos de redes', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:54:16', '2024-11-06 23:54:16', NULL, NULL, NULL, NULL, NULL, NULL),
	('0833', 'Equipamentos ativos de redes', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:54:33', '2024-11-06 23:54:33', NULL, NULL, NULL, NULL, NULL, NULL),
	('0834', 'Windows server - instalação e configuração de rede', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:55:00', '2024-11-06 23:55:00', NULL, NULL, NULL, NULL, NULL, NULL),
	('0835', 'Windows server - instalação e configuração de serviços', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:55:24', '2024-11-06 23:55:24', NULL, NULL, NULL, NULL, NULL, NULL),
	('0836', 'Linux - instalação e configuração', 25, 2, 'Tecnológica', NULL, '2024-11-06 23:55:52', '2024-11-06 23:55:52', NULL, NULL, NULL, NULL, NULL, NULL),
	('0837', 'Linux - kernel e componentes do sistema', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:56:17', '2024-11-06 23:56:17', NULL, NULL, NULL, NULL, NULL, NULL),
	('0838', 'Linux - administração', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:56:33', '2024-11-06 23:56:33', NULL, NULL, NULL, NULL, NULL, NULL),
	('0839', 'Linux - serviços de redes', 50, 2, 'Tecnológica', NULL, '2024-11-06 23:56:52', '2024-11-06 23:56:52', NULL, NULL, NULL, NULL, NULL, NULL),
	('0840', 'Servidores web', 50, 3, 'Tecnológica', '', '2024-11-06 23:57:16', '2024-11-06 23:57:16', 1, 0, 0, 1, 1, 1),
	('0841', 'Servidores web e acesso à internet', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:57:37', '2024-11-06 23:57:37', NULL, NULL, NULL, NULL, NULL, NULL),
	('0842', 'Servidores de e-mail - samba', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:57:59', '2024-11-06 23:57:59', NULL, NULL, NULL, NULL, NULL, NULL),
	('0843', 'Servidores de e-mail - postfix e data/hora', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:58:49', '2024-11-06 23:58:49', NULL, NULL, NULL, NULL, NULL, NULL),
	('0844', 'Segurança de redes', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:59:12', '2024-11-06 23:59:12', NULL, NULL, NULL, NULL, NULL, NULL),
	('0845', 'Segurança de redes - firewall', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:59:30', '2024-11-06 23:59:30', NULL, NULL, NULL, NULL, NULL, NULL),
	('0846', 'Instalação e gestão de redes - projeto', 50, 3, 'Tecnológica', NULL, '2024-11-06 23:59:53', '2024-11-06 23:59:53', NULL, NULL, NULL, NULL, NULL, NULL),
	('10791', 'Desenvolvimento de aplicações web em JAVA', 50, 3, 'Tecnológica', NULL, '2024-11-06 22:52:59', '2024-11-06 22:52:59', NULL, NULL, NULL, NULL, NULL, NULL),
	('6651', 'Portugal e a Europa', 50, 1, 'Sociocultural', 'Viver em português', '2024-11-06 22:06:31', '2024-11-06 22:06:43', NULL, NULL, NULL, NULL, NULL, NULL),
	('6652', 'Os media hoje', 25, 1, 'Sociocultural', 'Viver em português', '2024-11-06 22:07:00', '2024-11-06 22:07:00', NULL, NULL, NULL, NULL, NULL, NULL),
	('6653', 'Portugal e a sua História', 25, 1, 'Sociocultural', 'Viver em português', '2024-11-06 22:07:15', '2024-11-06 22:07:15', NULL, NULL, NULL, NULL, NULL, NULL),
	('6654', 'Ler a imprensa escrita', 25, 2, 'Sociocultural', 'Viver em português', '2024-11-06 22:07:49', '2024-11-06 22:07:49', NULL, NULL, NULL, NULL, NULL, NULL),
	('6655', 'A literatura do nosso tempo', 50, 2, 'Sociocultural', 'Viver em português', '2024-11-06 22:08:10', '2024-11-06 22:08:10', NULL, NULL, NULL, NULL, NULL, NULL),
	('6656', 'Mudanças profissionais e mercado de trabalho', 25, 2, 'Sociocultural', 'Viver em português', '2024-11-06 22:08:35', '2024-11-06 22:08:35', NULL, NULL, NULL, NULL, NULL, NULL),
	('6657', 'Diversidade linguística e cultural', 25, 3, 'Sociocultural', 'Viver em português', '2024-11-06 22:08:53', '2024-11-06 22:08:53', NULL, NULL, NULL, NULL, NULL, NULL),
	('6658', 'Procurar emprego', 50, 3, 'Sociocultural', 'Viver em português', '2024-11-06 22:09:16', '2024-11-06 22:09:16', NULL, NULL, NULL, NULL, NULL, NULL),
	('6659', 'Ler documentos informativos', 25, 1, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:11:17', '2024-11-06 22:11:17', NULL, NULL, NULL, NULL, NULL, NULL),
	('6660', 'Conhecer os problemas do mundo atual', 50, 1, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:12:34', '2024-11-06 22:12:34', NULL, NULL, NULL, NULL, NULL, NULL),
	('6661', 'Viajar na Europa', 25, 1, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:13:08', '2024-11-06 22:13:08', NULL, NULL, NULL, NULL, NULL, NULL),
	('6662', 'Escolher uma profissão/mudar de atividade', 25, 3, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:13:36', '2024-11-06 22:13:36', NULL, NULL, NULL, NULL, NULL, NULL),
	('6663', 'Debater os direitos e deveres dos cidadãos', 25, 3, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:14:00', '2024-11-06 22:14:00', NULL, NULL, NULL, NULL, NULL, NULL),
	('6664', 'Realizar uma exposição sobre as instituições internacionais', 50, 2, 'Sociocultural', 'Comunicar em língua inglesa', '2024-11-06 22:14:19', '2024-11-06 22:14:19', NULL, NULL, NULL, NULL, NULL, NULL),
	('6665', 'O homem e o ambiente', 25, 1, 'Sociocultural', 'Mundo atual', '2024-11-06 22:14:40', '2024-11-06 22:14:40', NULL, NULL, NULL, NULL, NULL, NULL),
	('6666', 'Publicidade: um discurso de sedução', 25, 1, 'Sociocultural', 'Mundo atual', '2024-11-06 22:20:30', '2024-11-06 22:20:30', NULL, NULL, NULL, NULL, NULL, NULL),
	('6667', 'Mundo atual - tema opcional', 25, 2, 'Sociocultural', 'Mundo atual', '2024-11-06 22:20:46', '2024-11-06 22:20:46', NULL, NULL, NULL, NULL, NULL, NULL),
	('6668', 'Uma nova ordem económica mundial', 25, 3, 'Sociocultural', 'Mundo atual', '2024-11-06 22:21:08', '2024-11-06 22:21:08', NULL, NULL, NULL, NULL, NULL, NULL),
	('6669', 'Higiene e prevenção no trabalho', 50, 1, 'Sociocultural', 'Desenvolvimento pessoal e social', '2024-11-06 22:21:36', '2024-11-06 22:21:36', NULL, NULL, NULL, NULL, NULL, NULL),
	('6670', 'Promoção da Saúde', 25, 2, 'Sociocultural', 'Desenvolvimento pessoal e social', '2024-11-06 22:21:56', '2024-11-06 22:21:56', NULL, NULL, NULL, NULL, NULL, NULL),
	('6671', 'Culturas, etnias e diversidades', 25, 3, 'Sociocultural', 'Desenvolvimento pessoal e social', '2024-11-06 22:22:14', '2024-11-06 22:22:14', NULL, NULL, NULL, NULL, NULL, NULL),
	('6672', 'Organização, análise da informação e probabilidades', 50, 1, 'Científica', 'Matemática e realidade', '2024-11-06 22:37:08', '2024-11-06 22:37:08', NULL, NULL, NULL, NULL, NULL, NULL),
	('6673', 'Operações numéricas e estimação', 25, 1, 'Científica', 'Matemática e realidade', '2024-11-06 22:37:27', '2024-11-06 22:37:27', NULL, NULL, NULL, NULL, NULL, NULL),
	('6674', 'Geometria e trigonometria', 50, 2, 'Científica', 'Matemática e realidade', '2024-11-06 22:37:43', '2024-11-06 22:37:43', NULL, NULL, NULL, NULL, NULL, NULL),
	('6675', 'Padrões, funções e álgebra', 25, 2, 'Científica', 'Matemática e realidade', '2024-11-06 22:38:00', '2024-11-06 22:38:00', NULL, NULL, NULL, NULL, NULL, NULL),
	('6676', 'Funções, limites e cálculo diferencial', 50, 3, 'Científica', 'Matemática e realidade', '2024-11-06 22:38:20', '2024-11-06 22:38:20', NULL, NULL, NULL, NULL, NULL, NULL),
	('6704', 'Movimentos e forças', 25, 1, 'Científica', 'Física', '2024-11-06 22:39:42', '2024-11-06 22:39:42', NULL, NULL, NULL, NULL, NULL, NULL),
	('6705', 'Sistemas termodinâmicos, elétricos e magnéticos', 25, 1, 'Científica', 'Física', '2024-11-06 22:39:58', '2024-11-06 22:39:58', NULL, NULL, NULL, NULL, NULL, NULL),
	('6706', 'Movimentos ondulatórios', 25, 2, 'Científica', 'Física', '2024-11-06 22:40:58', '2024-11-06 22:40:58', NULL, NULL, NULL, NULL, NULL, NULL),
	('6707', 'Física moderna - fundamentos', 25, 3, 'Científica', 'Física', '2024-11-06 22:41:26', '2024-11-06 22:41:26', NULL, NULL, NULL, NULL, NULL, NULL),
	('6708', 'Reações químicas e equilíbrio dinâmico', 25, 1, 'Científica', 'Química', '2024-11-06 22:42:10', '2024-11-06 22:42:10', NULL, NULL, NULL, NULL, NULL, NULL),
	('6709', 'Reações de ácidos-base e de oxidação-redução', 25, 2, 'Científica', 'Química', '2024-11-06 22:42:36', '2024-11-06 22:42:36', NULL, NULL, NULL, NULL, NULL, NULL),
	('6710', 'Reações de precipitação e equilíbrio heterogéneo', 25, 2, 'Científica', 'Química', '2024-11-06 22:42:57', '2024-11-06 22:42:57', NULL, NULL, NULL, NULL, NULL, NULL),
	('6711', 'Compostos orgânicos, polímeros, ligas metálicas e outros materiais', 25, 3, 'Científica', 'Química', '2024-11-06 22:43:25', '2024-11-06 22:43:25', NULL, NULL, NULL, NULL, NULL, NULL),
	('6713', 'Representação de figuras planas', 25, 1, 'Científica', 'Geometria Descritiva', '2024-11-07 00:08:58', '2024-11-07 00:08:58', NULL, NULL, NULL, NULL, NULL, NULL),
	('6714', 'Representação de sólidos', 50, 1, 'Científica', 'Geometria Descritiva', '2024-11-07 00:09:21', '2024-11-07 00:09:21', NULL, NULL, NULL, NULL, NULL, NULL),
	('6715', 'Interseções e secções', 50, 2, 'Científica', 'Geometria Descritiva', '2024-11-07 00:09:54', '2024-11-07 00:09:54', NULL, NULL, NULL, NULL, NULL, NULL),
	('6716', 'Sombras de figuras planas e de sólidos', 50, 3, 'Científica', 'Geometria Descritiva', '2024-11-07 00:10:23', '2024-11-07 00:10:23', NULL, NULL, NULL, NULL, NULL, NULL),
	('6720', 'Ordens e desordens no contexto da contemporaneidade', 25, 2, 'Científica', 'História das Artes', '2024-11-07 00:11:02', '2024-11-07 00:11:02', NULL, NULL, NULL, NULL, NULL, NULL),
	('7846', 'Informática - noções básicas', 50, 1, 'Tecnológica', NULL, '2024-11-06 23:33:48', '2024-11-06 23:33:48', NULL, NULL, NULL, NULL, NULL, NULL),
	('9604', 'Comunicação visual - o guião e o storyboard', 50, 2, 'Tecnológica', NULL, '2024-11-07 00:19:28', '2024-11-07 00:19:28', NULL, NULL, NULL, NULL, NULL, NULL),
	('9948', 'Redes e protocolos multimédia', 25, 1, 'Tecnológica', NULL, '2024-11-07 00:11:46', '2024-11-07 00:11:46', NULL, NULL, NULL, NULL, NULL, NULL),
	('9949', 'Construção de páginas web', 25, 1, 'Tecnológica', NULL, '2024-11-07 00:12:04', '2024-11-07 00:12:04', NULL, NULL, NULL, NULL, NULL, NULL),
	('9950', 'Conceitos fundamentais de programação', 50, 1, 'Tecnológica', NULL, '2024-11-07 00:12:25', '2024-11-07 00:12:25', NULL, NULL, NULL, NULL, NULL, NULL),
	('9951', 'Linguagem de programação web de servidor', 50, 1, 'Tecnológica', '', '2024-11-07 00:12:47', '2024-11-07 00:12:47', 1, 0, 0, 1, 1, 1),
	('9952', 'Programação de aplicações e sítios web dinâmicos', 50, 1, 'Tecnológica', NULL, '2024-11-07 00:13:24', '2024-11-07 00:13:24', NULL, NULL, NULL, NULL, NULL, NULL),
	('9953', 'Produção e promoção de produtos multimédia', 50, 1, 'Tecnológica', NULL, '2024-11-07 00:13:48', '2024-11-07 00:13:48', NULL, NULL, NULL, NULL, NULL, NULL),
	('9954', 'Fotografia e imagem digital', 25, 1, 'Tecnológica', NULL, '2024-11-07 00:17:04', '2024-11-07 00:17:04', NULL, NULL, NULL, NULL, NULL, NULL),
	('9955', 'Projeto de design', 25, 1, 'Tecnológica', NULL, '2024-11-07 00:17:24', '2024-11-07 00:17:24', NULL, NULL, NULL, NULL, NULL, NULL),
	('9956', 'Comunicação visual e abordagem da Gestalt', 25, 1, 'Tecnológica', NULL, '2024-11-07 00:17:52', '2024-11-07 00:17:52', NULL, NULL, NULL, NULL, NULL, NULL),
	('9957', 'Design de multimédia', 50, 1, 'Tecnológica', '', '2024-11-07 00:18:09', '2024-11-07 00:18:09', 0, 0, 0, 0, 0, 0),
	('9958', 'Arquitetura de informação', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:18:43', '2024-11-07 00:18:43', NULL, NULL, NULL, NULL, NULL, NULL),
	('9959', 'Laboratório de audiovisuais e interatividade', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:20:35', '2024-11-07 00:20:35', NULL, NULL, NULL, NULL, NULL, NULL),
	('9960', 'Edição bitmap', 50, 2, 'Tecnológica', NULL, '2024-11-07 00:20:51', '2024-11-07 00:20:51', NULL, NULL, NULL, NULL, NULL, NULL),
	('9961', 'Edição vetorial', 50, 2, 'Tecnológica', NULL, '2024-11-07 00:21:51', '2024-11-07 00:21:51', NULL, NULL, NULL, NULL, NULL, NULL),
	('9962', 'Técnicas de animação interativa', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:22:12', '2024-11-07 00:22:12', NULL, NULL, NULL, NULL, NULL, NULL),
	('9963', 'Edição web', 50, 2, 'Tecnológica', NULL, '2024-11-07 00:22:29', '2024-11-07 00:22:29', NULL, NULL, NULL, NULL, NULL, NULL),
	('9964', 'Edição de som', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:23:01', '2024-11-07 00:23:01', NULL, NULL, NULL, NULL, NULL, NULL),
	('9965', 'Edição de video', 25, 2, 'Tecnológica', NULL, '2024-11-07 00:38:04', '2024-11-07 00:38:04', NULL, NULL, NULL, NULL, NULL, NULL),
	('9966', 'Edição 3D', 50, 3, 'Tecnológica', NULL, '2024-11-07 00:38:26', '2024-11-07 00:38:26', NULL, NULL, NULL, NULL, NULL, NULL),
	('9967', 'Media, tecnologias emergentes e interação', 50, 3, 'Tecnológica', NULL, '2024-11-07 00:38:49', '2024-11-07 00:38:49', NULL, NULL, NULL, NULL, NULL, NULL);

-- A despejar estrutura para tabela escola.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nif` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- A despejar dados para tabela escola.usuarios: ~26 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `senha`, `tipo`, `email`, `nif`, `avatar`) VALUES
	(1, 'alexandra olival', '1234', 'professor', 'alexandraolival.lx@ita.learnstudio.com', 999999999, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(2, 'amelia correia', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(3, 'ana david', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(4, 'antonio gonçalves', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(5, 'carla  cardoso', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(6, 'carlos cruz', '1234', 'professor', 'carloscruz.lx@ita.learnstudio.com', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(7, 'carlos silva', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(8, 'celia lopes', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(9, 'diana saraiva', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(10, 'diogo algarvio', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(11, 'gonçalo rodrigues', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(12, 'marcelo abadie', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(13, 'maria rodrigues', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(14, 'maria rodrigo', '1234', 'professor', 'mariarodrigo.lx@ita.learnstudio.com', 999999999, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(15, 'patricia correia', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(16, 'pedro costa', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(17, 'renato anjos', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(18, 'rui emidio', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(19, 'sara polvora', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(20, 'silvia areias', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(21, 'vanessa soares', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(22, 'vasco ferreira', '1234', 'professor', 'a', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(23, 'claudia estevao', '1234', 'secretaria', 'claudiaestevao.lx@ita.learnstudio.com', 999999999, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(24, 'Direcao', '4321', 'admin', 'a', 1, 'https://cdn-icons-png.flaticon.com/512/78/78948.png'),
	(26, 'vasco salada', '1234', 'professor', 'vascosalada.x@ita.learstudio.com', 1, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg'),
	(30, 'ruben cruz', '1234', 'secretaria', 'rubencruz.lx@ita.learnstudio.com', 999999999, 'https://png.pngtree.com/png-vector/20191009/ourmid/pngtree-user-icon-png-image_1796659.jpg');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
