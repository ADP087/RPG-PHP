-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/05/2026 às 02:47
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `faight_rpg`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `guerreiros`
--

CREATE TABLE `guerreiros` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `classe` varchar(50) NOT NULL,
  `vida` int(11) NOT NULL,
  `ataque` int(11) NOT NULL,
  `defesa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `guerreiros`
--

INSERT INTO `guerreiros` (`id`, `nome`, `classe`, `vida`, `ataque`, `defesa`) VALUES
(1, 'Arthur', 'mago', 150, 180, 100),
(3, 'Arielli', 'arqueiro', 175, 150, 140),
(4, 'Vinícius', 'barbaro', 200, 180, 180);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `guerreiros`
--
ALTER TABLE `guerreiros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `guerreiros`
--
ALTER TABLE `guerreiros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
