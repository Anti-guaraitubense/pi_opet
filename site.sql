-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Jun-2023 às 21:57
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
  `id_bio` int(9) NOT NULL,
  `user_bio` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotoperfil`
--

CREATE TABLE `fotoperfil` (
  `id_foto` int(9) NOT NULL,
  `url_foto` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id_user` int(9) NOT NULL,
  `nome_user` varchar(20) NOT NULL,
  `senha_user` varchar(40) NOT NULL,
  `email_user` varchar(40) NOT NULL,
  `status_user` int(1) NOT NULL,
  `score_user` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bio`
--
ALTER TABLE `bio`
  ADD PRIMARY KEY (`id_bio`);

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
  MODIFY `id_bio` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fotoperfil`
--
ALTER TABLE `fotoperfil`
  MODIFY `id_foto` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_user` int(9) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;