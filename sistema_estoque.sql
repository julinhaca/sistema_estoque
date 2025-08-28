-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/08/2025 às 14:06
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_estoque`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(2, 'verduras'),
(3, 'carne'),
(4, 'bebidas'),
(5, 'limpeza'),
(6, 'higiene'),
(7, 'padaria'),
(8, 'congelados');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `tipo` enum('entrada','saida') NOT NULL,
  `quantidade` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `observacao` text NOT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacoes`
--

INSERT INTO `movimentacoes` (`id`, `produto_id`, `tipo`, `quantidade`, `usuario_id`, `observacao`, `data_movimentacao`) VALUES
(1, 20, 'entrada', 50, 3, 'entrada para acogue', '2025-08-11 19:46:51'),
(2, 1, 'entrada', 100, 3, 'Reposição de estoque', '2025-08-11 19:50:31'),
(3, 24, 'saida', 30, 3, 'Venda para cliente atacado', '2025-08-11 19:50:31'),
(4, 34, 'entrada', 50, 3, 'Compra de fornecedor', '2025-08-11 19:50:31'),
(5, 18, 'saida', 10, 3, 'Venda para churrascaria', '2025-08-11 19:50:31'),
(6, 25, 'entrada', 200, 3, 'Estoque para o verão', '2025-08-11 19:50:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade_estoque` int(11) DEFAULT 0,
  `categoria_id` int(11) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`, `quantidade_estoque`, `categoria_id`, `criado_em`) VALUES
(1, 'tomate', 'tomate ', 2.55, 20, 2, '2025-08-04 11:52:38'),
(3, 'cenoura', 'cenoura', 3.50, 50, 2, '2025-08-05 19:57:17'),
(5, 'peito de frango ', 'fsdfs', 14.50, 50, 3, '2025-08-05 19:59:02'),
(6, 'Alface', 'Alface americana', 1.00, 100, 2, '2025-08-05 20:28:25'),
(7, 'Cenoura', 'Cenoura fresca', 3.00, 80, 2, '2025-08-05 20:28:25'),
(8, 'Batata', 'Batata inglesa', 2.00, 120, 2, '2025-08-05 20:28:25'),
(9, 'Cebola', 'Cebola roxa', 3.00, 90, 2, '2025-08-05 20:28:25'),
(10, 'Abobrinha', 'Abobrinha verde', 3.00, 60, 2, '2025-08-05 20:28:25'),
(11, 'Espinafre', 'Espinafre orgânico', 2.00, 70, 2, '2025-08-05 20:28:25'),
(12, 'Pimentão', 'Pimentão vermelho', 4.00, 50, 2, '2025-08-05 20:28:25'),
(13, 'Brócolis', 'Brócolis ninja', 5.00, 45, 2, '2025-08-05 20:28:25'),
(14, 'Tomate', 'Tomate italiano', 2.00, 130, 2, '2025-08-05 20:28:25'),
(15, 'Contra Filé', 'Carne bovina de primeira', 28.00, 40, 3, '2025-08-05 20:28:25'),
(16, 'Frango', 'Coxa e sobrecoxa', 12.00, 100, 3, '2025-08-05 20:28:25'),
(17, 'Linguiça', 'Linguiça toscana', 16.00, 60, 3, '2025-08-05 20:28:25'),
(18, 'Picanha', 'Picanha maturada', 45.00, 25, 3, '2025-08-05 20:28:25'),
(19, 'Costela', 'Costela bovina', 22.00, 30, 3, '2025-08-05 20:28:25'),
(20, 'Carne Moída', 'Patinho moído fresco', 20.00, 50, 3, '2025-08-05 20:28:25'),
(21, 'Peito de Frango', 'Peito desossado', 14.00, 80, 3, '2025-08-05 20:28:25'),
(22, 'Filé de Frango', 'Filé fininho', 15.00, 90, 3, '2025-08-05 20:28:25'),
(23, 'Bisteca Suína', 'Corte suíno com osso', 17.00, 70, 3, '2025-08-05 20:28:25'),
(24, 'Coca-Cola 2L', 'Refrigerante Coca-Cola 2 litros', 7.00, 100, 4, '2025-08-05 20:30:44'),
(25, 'Água Mineral 500ml', 'Sem gás', 1.00, 200, 4, '2025-08-05 20:30:44'),
(26, 'Suco de Laranja', 'Natural One 1L', 9.00, 60, 4, '2025-08-05 20:30:44'),
(27, 'Guaraná Antarctica', 'Lata 350ml', 3.00, 150, 4, '2025-08-05 20:30:44'),
(28, 'Energético Red Bull', 'Lata 250ml', 9.00, 80, 4, '2025-08-05 20:30:44'),
(29, 'Detergente Ypê', '500ml neutro', 2.00, 120, 5, '2025-08-05 20:30:44'),
(30, 'Desinfetante Pinho Sol', '500ml', 4.00, 90, 5, '2025-08-05 20:30:44'),
(31, 'Sabão em Pó Omo', '1kg', 12.00, 75, 5, '2025-08-05 20:30:44'),
(32, 'Água Sanitária', '1L', 4.00, 110, 5, '2025-08-05 20:30:44'),
(33, 'Esponja de Limpeza', 'Pacote com 3 unidades', 5.00, 60, 5, '2025-08-05 20:30:44'),
(34, 'Sabonete Dove', 'Sabonete 90g', 4.00, 100, 6, '2025-08-05 20:30:44'),
(35, 'Shampoo Pantene', 'Brilho Extremo 400ml', 16.00, 80, 6, '2025-08-05 20:30:44'),
(36, 'Papel Higiênico Neve', 'Pacote com 12 rolos', 18.00, 60, 6, '2025-08-05 20:30:44'),
(37, 'Desodorante Rexona', 'Aerosol 150ml', 10.00, 90, 6, '2025-08-05 20:30:44'),
(38, 'Creme Dental Colgate', '90g', 3.00, 150, 6, '2025-08-05 20:30:44'),
(39, 'Pão Francês', 'Por kg', 10.00, 40, 7, '2025-08-05 20:30:44'),
(40, 'Pão de Forma', 'Fatiado 500g', 7.00, 30, 7, '2025-08-05 20:30:44'),
(41, 'Bolo de Chocolate', 'Fatia média', 5.00, 50, 7, '2025-08-05 20:30:44'),
(42, 'Croissant', 'Recheado com presunto e queijo', 6.00, 25, 7, '2025-08-05 20:30:44'),
(43, 'Sonho', 'Com creme', 4.00, 40, 7, '2025-08-05 20:30:44'),
(44, 'Pizza Congelada', 'Calabresa 460g', 15.00, 35, 8, '2025-08-05 20:30:44'),
(45, 'Hambúrguer Congelado', 'Caixa com 4 unid.', 11.00, 60, 8, '2025-08-05 20:30:44'),
(46, 'Nuggets Sadia', '300g', 10.00, 70, 8, '2025-08-05 20:30:44'),
(47, 'Lasanha Perdigão', 'Bolonhesa 600g', 12.00, 50, 8, '2025-08-05 20:30:44'),
(48, 'Sorvete Kibon', '2L sabor napolitano', 22.00, 45, 8, '2025-08-05 20:30:44'),
(49, 'Sabão Liquido OMO ', 'Sabão líquido para roupas, 3L', 22.90, 50, 5, '2025-08-07 13:22:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(3, 'fatima', 'fatima@funcionario.com', '$2y$10$0p7RrEXRZMi6tHAgNz8KEuB0fENm45QVXHHZGv.bFzbVsnH0.urAy', '2025-08-03 14:31:54');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD CONSTRAINT `movimentacoes_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `movimentacoes_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
