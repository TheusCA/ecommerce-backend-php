-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Set-2025 às 02:39
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Banco de dados: `sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `account`
--

INSERT INTO `account` (`id`, `username`, `password`) VALUES
(1, 'demo', '*3055544BD641D0814B910C4ACA5799F51B80F460'),
(2, 'teste', '*54F70B7C45C0C6359C49B71D12ADE9C4422D8DC8');

-- --------------------------------------------------------

--
-- Estrutura da tabela `prod`
--

CREATE TABLE `prod` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `prod`
--

INSERT INTO `prod` (`id`, `nome`, `preco`) VALUES
(7, 'Mochila', 199.00),
(8, 'Caneta', 5.00),
(9, 'Caderno', 19.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `prod`
--
ALTER TABLE `prod`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `prod`
--
ALTER TABLE `prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;


--
-- Estrutura da tabela `category`
--
CREATE TABLE `category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Adicionar coluna `category_id` na tabela `prod`
--
ALTER TABLE `prod`
ADD COLUMN `category_id` INT(11) NULL AFTER `preco`;
--
-- Adicionar chave estrangeira para `category_id` na tabela `prod`
--
ALTER TABLE `prod`
ADD CONSTRAINT `fk_category`
FOREIGN KEY (`category_id`)
REFERENCES `category`(`id`)
ON DELETE SET NULL ON UPDATE CASCADE;

