-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Jun-2023 às 02:35
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `doacao`
--

CREATE TABLE `doacao` (
  `id_doacao` int(9) NOT NULL,
  `nome_doacao` varchar(40) NOT NULL,
  `img_doacao` varchar(40) NOT NULL,
  `status_doacao` int(9) NOT NULL,
  `user_doador` int(11) NOT NULL,
  `validade_doacao` varchar(40) NOT NULL,
  `data_doacao` varchar(40) NOT NULL,
  `id_avaliador` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotoperfil`
--

CREATE TABLE `fotoperfil` (
  `id_foto` int(11) NOT NULL,
  `url_foto` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id_user` int(11) NOT NULL,
  `nome_user` varchar(40) NOT NULL,
  `senha_user` varchar(60) NOT NULL,
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


CREATE TABLE `cartao` (
  `id_cartao` int(11) NOT NULL,
  `id_user_cartao` int(11) NOT NULL,
  `nome_cartao` varchar(40),
  `nmr_cartao` varchar(16),
  `mesv_cartao` varchar(20),
  `anov_cartao` varchar(20),
  `cvv_cartao` varchar(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bio`
--
ALTER TABLE `bio`
  ADD PRIMARY KEY (`id_bio`);

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
  MODIFY `id_bio` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cartao`
  MODIFY `id_cartao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `doacao`
--
ALTER TABLE `doacao`
  MODIFY `id_doacao` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fotoperfil`
--
ALTER TABLE `fotoperfil`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
