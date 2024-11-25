CREATE TABLE `tis8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `horas` int(11) NOT NULL,
  `professor` varchar(100) NOT NULL,
  `concluida` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `turmas` (id, nome, inicio, fim, curso, professor) VALUES ('10', 'tis8', '2023', '2024', 'Tecnico de Informática', 'Diana Saraiva');
