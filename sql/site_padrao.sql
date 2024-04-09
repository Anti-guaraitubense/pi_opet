-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08-Abr-2024 às 21:24
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `site`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bio`
--

CREATE TABLE `bio` (
  `id_bio` int(11) NOT NULL,
  `user_bio` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `bio`
--

INSERT INTO `bio` (`id_bio`, `user_bio`) VALUES
(1, 'usuario padrão'),
(2, 'Analista do site Doasans!!'),
(3, 'Admin do Doasans!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartao`
--

CREATE TABLE `cartao` (
  `id_cartao` int(11) NOT NULL,
  `id_user_cartao` int(11) NOT NULL,
  `nome_cartao` varchar(40) DEFAULT NULL,
  `nmr_cartao` varchar(16) DEFAULT NULL,
  `mesv_cartao` varchar(20) DEFAULT NULL,
  `anov_cartao` varchar(20) DEFAULT NULL,
  `cvv_cartao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `configuracao`
--

CREATE TABLE `configuracao` (
  `id_user_cfg` int(9) NOT NULL,
  `site_theme` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `configuracao`
--

INSERT INTO `configuracao` (`id_user_cfg`, `site_theme`) VALUES
(1, 'dark_theme'),
(2, 'dark_theme'),
(3, 'dark_theme');

-- --------------------------------------------------------

--
-- Estrutura da tabela `doacao`
--

CREATE TABLE `doacao` (
  `id_doacao` int(9) NOT NULL,
  `nome_doacao` varchar(40) NOT NULL,
  `img_doacao` varchar(40) NOT NULL,
  `img_validade` varchar(40) NOT NULL,
  `status_doacao` int(9) NOT NULL,
  `user_doador` int(11) NOT NULL,
  `validade_doacao` varchar(40) NOT NULL,
  `data_doacao` varchar(40) NOT NULL,
  `id_validador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotoperfil`
--

CREATE TABLE `fotoperfil` (
  `id_foto` int(11) NOT NULL,
  `url_foto` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `fotoperfil`
--

INSERT INTO `fotoperfil` (`id_foto`, `url_foto`) VALUES
(1, 'img/pfp/defaultpic.jpg'),
(2, 'img/pfp/defaultpic.jpg'),
(3, 'img/pfp/defaultpic.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id_user` int(11) NOT NULL,
  `nome_user` varchar(40) NOT NULL,
  `senha_user` varchar(255) NOT NULL,
  `email_user` varchar(40) NOT NULL,
  `status_user` int(10) NOT NULL,
  `score_user` int(10) NOT NULL,
  `user_perm` int(10) NOT NULL,
  `doador_user` int(10) NOT NULL,
  `posdoador_user` int(10) NOT NULL,
  `cpf_user` varchar(11) NOT NULL,
  `cep_user` varchar(10) NOT NULL,
  `nmr_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id_user`, `nome_user`, `senha_user`, `email_user`, `status_user`, `score_user`, `user_perm`, `doador_user`, `posdoador_user`, `cpf_user`, `cep_user`, `nmr_user`) VALUES
(1, 'user', '$2y$10$DeQxN3GGXsZzLUKSjHPSCedn79AoPfKr1XFDI9f6bj.R1jYa1xTAW', 'user@gmail.com', 1, 0, 0, 0, 0, '', '', ''),
(2, 'analista', '$2y$10$M/LKTTizQQAy.vsWHHhIWeQFBPNYX/ibgL0qgBRGMN8N4kXteQ/Iu', 'analista@gmail.com', 1, 0, 0, 0, 0, '', '', ''),
(3, 'admin', '$2y$10$4tKX9AqazvIsV15PoPYyTO4LHitBgmzZjQoajA9wjSXD1I6tHY77O', 'admin@gmail.com', 1, 0, 0, 0, 0, '', '', '');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bio`
--
ALTER TABLE `bio`
  ADD PRIMARY KEY (`id_bio`);

--
-- Índices para tabela `cartao`
--
ALTER TABLE `cartao`
  ADD PRIMARY KEY (`id_cartao`);

--
-- Índices para tabela `doacao`
--
ALTER TABLE `doacao`
  ADD PRIMARY KEY (`id_doacao`);

--
-- Índices para tabela `fotoperfil`
--
ALTER TABLE `fotoperfil`
  ADD PRIMARY KEY (`id_foto`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bio`
--
ALTER TABLE `bio`
  MODIFY `id_bio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cartao`
--
ALTER TABLE `cartao`
  MODIFY `id_cartao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `doacao`
--
ALTER TABLE `doacao`
  MODIFY `id_doacao` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `fotoperfil`
--
ALTER TABLE `fotoperfil`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
