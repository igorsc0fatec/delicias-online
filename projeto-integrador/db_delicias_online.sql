-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/06/2024 às 18:03
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
-- Banco de dados: `db_delicias_online`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcliente`
--

CREATE TABLE `tbcliente` (
  `idCliente` int(11) NOT NULL,
  `nomeCliente` varchar(100) DEFAULT NULL,
  `cpfCliente` varchar(14) DEFAULT NULL,
  `nascCliente` date DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcliente`
--

INSERT INTO `tbcliente` (`idCliente`, `nomeCliente`, `cpfCliente`, `nascCliente`, `idUsuario`) VALUES
(1, 'Igor', '349.437.000-12', '2000-06-21', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbcobertura`
--

CREATE TABLE `tbcobertura` (
  `idCobertura` int(11) NOT NULL,
  `descCobertura` varchar(100) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbcobertura`
--

INSERT INTO `tbcobertura` (`idCobertura`, `descCobertura`, `idConfeitaria`) VALUES
(1, 'Chantili', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbconfeitaria`
--

CREATE TABLE `tbconfeitaria` (
  `idConfeitaria` int(11) NOT NULL,
  `nomeConfeitaria` varchar(100) DEFAULT NULL,
  `cnpjConfeitaria` varchar(18) DEFAULT NULL,
  `cepConfeitaria` varchar(9) DEFAULT NULL,
  `logConfeitaria` varchar(100) DEFAULT NULL,
  `numLocal` varchar(30) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairroConfeitaria` varchar(100) DEFAULT NULL,
  `cidadeConfeitaria` varchar(100) DEFAULT NULL,
  `ufConfeitaria` varchar(2) DEFAULT NULL,
  `imgConfeitaria` varchar(255) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbconfeitaria`
--

INSERT INTO `tbconfeitaria` (`idConfeitaria`, `nomeConfeitaria`, `cnpjConfeitaria`, `cepConfeitaria`, `logConfeitaria`, `numLocal`, `complemento`, `bairroConfeitaria`, `cidadeConfeitaria`, `ufConfeitaria`, `imgConfeitaria`, `idUsuario`) VALUES
(1, 'Delicias da Nice', '21.604.515/0001-70', '08502-310', 'Rua Marcondes Salgado', '600', NULL, 'Vila Correa', 'Ferraz de Vasconcelos', 'SP', 'img/img-confeitaria/conf.jpg', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbconversa`
--

CREATE TABLE `tbconversa` (
  `idConversa` int(11) NOT NULL,
  `lido` varchar(1) DEFAULT NULL,
  `modificado` datetime DEFAULT NULL,
  `criacao` datetime DEFAULT NULL,
  `idPrincipal` int(11) DEFAULT NULL,
  `idOutro` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbconversa`
--

INSERT INTO `tbconversa` (`idConversa`, `lido`, `modificado`, `criacao`, `idPrincipal`, `idOutro`) VALUES
(1, 'y', NULL, '2024-06-26 20:03:32', 1, 2),
(2, 'y', NULL, '2024-06-26 20:03:32', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbddd`
--

CREATE TABLE `tbddd` (
  `idDDD` int(11) NOT NULL,
  `ddd` varchar(2) DEFAULT NULL,
  `ufDDD` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbddd`
--

INSERT INTO `tbddd` (`idDDD`, `ddd`, `ufDDD`) VALUES
(1, '11', 'SP'),
(2, '12', 'SP'),
(3, '13', 'SP'),
(4, '14', 'SP'),
(5, '15', 'SP'),
(6, '16', 'SP'),
(7, '17', 'SP'),
(8, '18', 'SP'),
(9, '19', 'SP'),
(10, '21', 'RJ'),
(11, '22', 'RJ'),
(12, '24', 'RJ'),
(13, '27', 'ES'),
(14, '28', 'ES'),
(15, '31', 'MG'),
(16, '32', 'MG'),
(17, '33', 'MG'),
(18, '34', 'MG'),
(19, '35', 'MG'),
(20, '37', 'MG'),
(21, '38', 'MG'),
(22, '41', 'PR'),
(23, '42', 'PR'),
(24, '43', 'PR'),
(25, '44', 'PR'),
(26, '45', 'PR'),
(27, '46', 'PR'),
(28, '47', 'SC'),
(29, '48', 'SC'),
(30, '49', 'SC'),
(31, '51', 'RS'),
(32, '53', 'RS'),
(33, '54', 'RS'),
(34, '55', 'RS'),
(35, '61', 'DF'),
(36, '62', 'GO'),
(37, '63', 'GO'),
(38, '64', 'GO'),
(39, '65', 'MT'),
(40, '66', 'MT'),
(41, '67', 'MS'),
(42, '68', 'AC'),
(43, '69', 'RO'),
(44, '71', 'BA'),
(45, '73', 'BA'),
(46, '74', 'BA'),
(47, '75', 'BA'),
(48, '77', 'BA'),
(49, '79', 'BA'),
(50, '81', 'PE'),
(51, '82', 'AL'),
(52, '83', 'AL'),
(53, '84', 'RN'),
(54, '85', 'CE'),
(55, '86', 'PI'),
(56, '87', 'PE'),
(57, '88', 'CE'),
(58, '89', 'PI'),
(59, '91', 'PA'),
(60, '92', 'AM'),
(61, '93', 'AM'),
(62, '94', 'PA'),
(63, '95', 'RR'),
(64, '96', 'AP'),
(65, '97', 'AM'),
(66, '98', 'MA'),
(67, '99', 'MA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbdecoracao`
--

CREATE TABLE `tbdecoracao` (
  `idDecoracao` int(11) NOT NULL,
  `descDecoracao` varchar(100) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbdecoracao`
--

INSERT INTO `tbdecoracao` (`idDecoracao`, `descDecoracao`, `idConfeitaria`) VALUES
(1, 'Desenho animado', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbenderecocliente`
--

CREATE TABLE `tbenderecocliente` (
  `idEnderecoCliente` int(11) NOT NULL,
  `cepCliente` varchar(9) DEFAULT NULL,
  `logCliente` varchar(100) DEFAULT NULL,
  `numLocal` varchar(30) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairroCliente` varchar(100) DEFAULT NULL,
  `cidadeCliente` varchar(100) DEFAULT NULL,
  `ufCliente` varchar(2) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbenderecocliente`
--

INSERT INTO `tbenderecocliente` (`idEnderecoCliente`, `cepCliente`, `logCliente`, `numLocal`, `complemento`, `bairroCliente`, `cidadeCliente`, `ufCliente`, `idCliente`) VALUES
(1, '08502-000', 'Avenida Brasil', '300', NULL, 'Vila Correa', 'Ferraz de Vasconcelos', 'SP', 1),
(2, '08502-020', 'Rua Santos Dumont', '200', NULL, 'Vila Correa', 'Ferraz de Vasconcelos', 'SP', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbformapagamento`
--

CREATE TABLE `tbformapagamento` (
  `idFormaPagamento` int(11) NOT NULL,
  `formaPagamento` varchar(150) DEFAULT NULL,
  `descricao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbformapagamento`
--

INSERT INTO `tbformapagamento` (`idFormaPagamento`, `formaPagamento`, `descricao`) VALUES
(1, 'Dinheiro', 'Pagamento em espécie'),
(2, 'Cartão de Crédito', 'Pagamento com cartão de crédito'),
(3, 'Cartão de Débito', 'Pagamento com cartão de débito'),
(4, 'Boleto Bancário', 'Pagamento via boleto bancário'),
(5, 'Transferência Bancária', 'Pagamento via transferência bancária'),
(6, 'PIX', 'Pagamento instantâneo via PIX'),
(7, 'Carteiras Digitais', 'Pagamento via carteiras digitais como PayPal, Google Pay, Apple Pay'),
(8, 'Débito Automático', 'Pagamento via débito automático em conta'),
(9, 'Vale Refeição', 'Pagamento com vale refeição como VR, Ticket'),
(10, 'Vale Alimentação', 'Pagamento com vale alimentação como Sodexo, Alelo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbformato`
--

CREATE TABLE `tbformato` (
  `idFormato` int(11) NOT NULL,
  `descFormato` varchar(100) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbformato`
--

INSERT INTO `tbformato` (`idFormato`, `descFormato`, `idConfeitaria`) VALUES
(1, 'Redondo', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbitenspedido`
--

CREATE TABLE `tbitenspedido` (
  `idItensPedido` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `idProduto` int(11) DEFAULT NULL,
  `idPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbitenspedido`
--

INSERT INTO `tbitenspedido` (`idItensPedido`, `quantidade`, `idProduto`, `idPedido`) VALUES
(110, 1, 1, 60),
(111, 1, 2, 60),
(112, 1, 3, 61),
(113, 3, 5, 61),
(114, 5, 1, 62);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmassa`
--

CREATE TABLE `tbmassa` (
  `idMassa` int(11) NOT NULL,
  `descMassa` varchar(100) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbmassa`
--

INSERT INTO `tbmassa` (`idMassa`, `descMassa`, `idConfeitaria`) VALUES
(1, 'Bolo', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbmensagem`
--

CREATE TABLE `tbmensagem` (
  `idMensagem` int(11) NOT NULL,
  `mensagem` varchar(200) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `dataEnvio` datetime DEFAULT NULL,
  `idRemetente` int(11) DEFAULT NULL,
  `idDestinatario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbmensagem`
--

INSERT INTO `tbmensagem` (`idMensagem`, `mensagem`, `imagem`, `dataEnvio`, `idRemetente`, `idDestinatario`) VALUES
(1, 'o', '', '2024-06-26 20:03:32', 1, 2),
(2, 'u', '', '2024-06-26 20:03:40', 1, 2),
(3, 'u', '', '2024-06-26 20:03:58', 1, 2),
(4, 'u', '', '2024-06-26 20:26:58', 1, 2),
(5, '', 'img/img-chat/oi.png', '2024-06-26 20:35:21', 1, 2),
(6, 'salve', '', '2024-06-26 20:35:54', 2, 1),
(7, '', '../img-chat/bolo_c.jpg', '2024-06-26 21:37:14', 2, 1),
(8, '', '../img-chat/bolo.jpg', '2024-06-30 12:17:25', 1, 2),
(9, 'oiee', '', '2024-06-30 12:18:02', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedido`
--

CREATE TABLE `tbpedido` (
  `idPedido` int(11) NOT NULL,
  `valorTotal` decimal(8,2) DEFAULT NULL,
  `desconto` decimal(8,2) DEFAULT NULL,
  `dataPedido` date DEFAULT NULL,
  `horaPedido` time DEFAULT NULL,
  `frete` decimal(6,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `idEnderecoCliente` int(11) DEFAULT NULL,
  `idFormaPagamento` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedido`
--

INSERT INTO `tbpedido` (`idPedido`, `valorTotal`, `desconto`, `dataPedido`, `horaPedido`, `frete`, `status`, `idEnderecoCliente`, `idFormaPagamento`, `idCliente`) VALUES
(60, 65.00, 0.00, '2024-06-24', '22:08:45', 5.00, 'Em Rota de Entrega!', 1, 6, 1),
(61, 73.00, 0.00, '2024-06-24', '22:11:36', 3.00, 'Pedido Cancelado!', 2, 5, 1),
(62, 155.00, 0.00, '2024-06-30', '12:19:12', 5.00, 'Pedido Recebido!', 1, 6, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpedidopersonalizado`
--

CREATE TABLE `tbpedidopersonalizado` (
  `idPedidoPersonalizado` int(11) NOT NULL,
  `valorTotal` decimal(8,2) DEFAULT NULL,
  `desconto` decimal(8,2) DEFAULT NULL,
  `dataPedido` date DEFAULT NULL,
  `horaPedido` time DEFAULT NULL,
  `frete` decimal(6,2) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `idEnderecoCliente` int(11) DEFAULT NULL,
  `idFormaPagamento` int(11) DEFAULT NULL,
  `idMassa` int(11) DEFAULT NULL,
  `idRecheio` int(11) DEFAULT NULL,
  `idCobertura` int(11) DEFAULT NULL,
  `idFormato` int(11) DEFAULT NULL,
  `idDecoracao` int(11) DEFAULT NULL,
  `idPersonalizado` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpedidopersonalizado`
--

INSERT INTO `tbpedidopersonalizado` (`idPedidoPersonalizado`, `valorTotal`, `desconto`, `dataPedido`, `horaPedido`, `frete`, `status`, `idEnderecoCliente`, `idFormaPagamento`, `idMassa`, `idRecheio`, `idCobertura`, `idFormato`, `idDecoracao`, `idPersonalizado`, `idCliente`) VALUES
(1, 0.00, 0.00, '2024-06-22', '21:46:11', 0.00, 'Pedido Cancelado!', 1, NULL, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpersonalizado`
--

CREATE TABLE `tbpersonalizado` (
  `idPersonalizado` int(11) NOT NULL,
  `nomePersonalizado` varchar(100) DEFAULT NULL,
  `descPersonalizado` varchar(200) DEFAULT NULL,
  `imgPersonalizado` varchar(255) DEFAULT NULL,
  `qtdPersonalizado` int(11) DEFAULT NULL,
  `ativoPersonalizado` tinyint(1) DEFAULT NULL,
  `idPeso` int(11) DEFAULT NULL,
  `idTipoProduto` int(11) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpersonalizado`
--

INSERT INTO `tbpersonalizado` (`idPersonalizado`, `nomePersonalizado`, `descPersonalizado`, `imgPersonalizado`, `qtdPersonalizado`, `ativoPersonalizado`, `idPeso`, `idTipoProduto`, `idConfeitaria`) VALUES
(1, 'a', 'a', 'img/img-personalizado/bolo.jpg', 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbpeso`
--

CREATE TABLE `tbpeso` (
  `idPeso` int(11) NOT NULL,
  `peso` decimal(4,3) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbpeso`
--

INSERT INTO `tbpeso` (`idPeso`, `peso`, `idConfeitaria`) VALUES
(1, 1.000, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbproduto`
--

CREATE TABLE `tbproduto` (
  `idProduto` int(11) NOT NULL,
  `nomeProduto` varchar(100) DEFAULT NULL,
  `descProduto` varchar(200) DEFAULT NULL,
  `valorProduto` decimal(9,2) DEFAULT NULL,
  `frete` decimal(6,2) DEFAULT NULL,
  `ativoProduto` tinyint(1) DEFAULT NULL,
  `imgProduto` varchar(255) DEFAULT NULL,
  `idTipoProduto` int(11) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbproduto`
--

INSERT INTO `tbproduto` (`idProduto`, `nomeProduto`, `descProduto`, `valorProduto`, `frete`, `ativoProduto`, `imgProduto`, `idTipoProduto`, `idConfeitaria`) VALUES
(1, 'Bolo de Chocolate', 'Bolo de chocolate úmido com cobertura de ganache', 30.00, 5.00, 1, 'img/img-produto/bolo_c.jpg', 1, 1),
(2, 'Torta de Limão', 'Torta de limão cremosa com merengue tostado', 25.00, 5.00, 1, 'img/img-produto/torta-limao.jpg', 2, 1),
(3, 'Cheesecake de Morango', 'Cheesecake clássico com calda fresca de morango', 35.00, 5.00, 1, 'img/img-produto/cheeskake.jpg', 13, 1),
(4, 'Brownie', 'Brownie denso e rico com nozes e pedaços de chocolate', 20.00, 5.00, 1, 'img/img-produto/OIP.jpg', 12, 1),
(5, 'Suco Natural', 'Suco natural de laranja fresco e sem conservantes', 10.00, 3.00, 1, 'img/img-produto/suco.png', 15, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbrecheio`
--

CREATE TABLE `tbrecheio` (
  `idRecheio` int(11) NOT NULL,
  `descRecheio` varchar(100) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbrecheio`
--

INSERT INTO `tbrecheio` (`idRecheio`, `descRecheio`, `idConfeitaria`) VALUES
(1, 'Chocolate', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbsuporte`
--

CREATE TABLE `tbsuporte` (
  `idSuporte` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `descSuporte` varchar(150) DEFAULT NULL,
  `resolvido` tinyint(1) DEFAULT NULL,
  `idTipoSuporte` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtelcliente`
--

CREATE TABLE `tbtelcliente` (
  `idTelCliente` int(11) NOT NULL,
  `numTelCliente` varchar(14) DEFAULT NULL,
  `idDDD` int(11) DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idTipoTelefone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtelconfeitaria`
--

CREATE TABLE `tbtelconfeitaria` (
  `idTelConfeitaria` int(11) NOT NULL,
  `numTelConfeitaria` varchar(14) DEFAULT NULL,
  `idDDD` int(11) DEFAULT NULL,
  `idConfeitaria` int(11) DEFAULT NULL,
  `idTipoTelefone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbtelconfeitaria`
--

INSERT INTO `tbtelconfeitaria` (`idTelConfeitaria`, `numTelConfeitaria`, `idDDD`, `idConfeitaria`, `idTipoTelefone`) VALUES
(2, '(11)11111-1111', 1, 1, 1),
(3, '(11)22222-2222', 1, 1, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtipoproduto`
--

CREATE TABLE `tbtipoproduto` (
  `idTipoProduto` int(11) NOT NULL,
  `tipoProduto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbtipoproduto`
--

INSERT INTO `tbtipoproduto` (`idTipoProduto`, `tipoProduto`) VALUES
(1, 'Bolos'),
(2, 'Tortas'),
(3, 'Cupcakes'),
(4, 'Brigadeiros'),
(5, 'Doces diversos'),
(6, 'Bem-casados'),
(7, 'Pães de mel'),
(8, 'Trufas'),
(9, 'Bombons'),
(10, 'Macarons'),
(11, 'Cookies'),
(12, 'Brownies'),
(13, 'Cheesecakes'),
(14, 'Salgados'),
(15, 'Bebidas');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtiposuporte`
--

CREATE TABLE `tbtiposuporte` (
  `idTipoSuporte` int(11) NOT NULL,
  `tipoSuporte` varchar(150) DEFAULT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbtiposuporte`
--

INSERT INTO `tbtiposuporte` (`idTipoSuporte`, `tipoSuporte`, `idTipoUsuario`) VALUES
(1, 'Problemas com os dados pessoais', 2),
(2, 'Problemas com os dados da confeitaria', 3),
(3, 'Problemas com o meu telefone', 2),
(4, 'Problemas com o meu telefone', 3),
(5, 'Problemas com o meu endereço', 2),
(6, 'Quero desativar minha conta', 2),
(7, 'Quero desativar minha conta', 3),
(8, 'Problemas com produtos', 3),
(9, 'Problemas com regras de produtos', 3),
(10, 'Problemas com produtos personalizados', 3),
(11, 'Problemas para pedir um produto personalizado', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtipotelefone`
--

CREATE TABLE `tbtipotelefone` (
  `idTipoTelefone` int(11) NOT NULL,
  `tipoTelefone` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbtipotelefone`
--

INSERT INTO `tbtipotelefone` (`idTipoTelefone`, `tipoTelefone`) VALUES
(1, 'Whats App'),
(2, 'Fixo'),
(3, 'Celular');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbtipousuario`
--

CREATE TABLE `tbtipousuario` (
  `idTipoUsuario` int(11) NOT NULL,
  `nomeTipoUsuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbtipousuario`
--

INSERT INTO `tbtipousuario` (`idTipoUsuario`, `nomeTipoUsuario`) VALUES
(1, 'root'),
(2, 'cliente'),
(3, 'confeitaria');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tbusuario`
--

CREATE TABLE `tbusuario` (
  `idUsuario` int(11) NOT NULL,
  `emailUsuario` varchar(150) DEFAULT NULL,
  `emailVerificado` tinyint(1) DEFAULT NULL,
  `contaAtiva` tinyint(1) DEFAULT NULL,
  `senhaUsuario` varchar(150) DEFAULT NULL,
  `online` datetime DEFAULT NULL,
  `dataCriacao` datetime DEFAULT NULL,
  `idTipoUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tbusuario`
--

INSERT INTO `tbusuario` (`idUsuario`, `emailUsuario`, `emailVerificado`, `contaAtiva`, `senhaUsuario`, `online`, `dataCriacao`, `idTipoUsuario`) VALUES
(1, 'igor.cardoso4@fatec.sp.gov.br', 1, 1, '$2y$10$YH3ctxcZDlCQ.qauGKxfu.vdnAqF36KRlkNqzN8KV6MUaSIskZZuG', '2024-06-30 17:16:00', '2024-06-22 00:00:00', 2),
(2, 'emulador.igor2@gmail.com', 1, 1, '$2y$10$lVLMVjzk.Fkmy1cRsW7kyOgbwM8bC5w9xUvP5IOZuHwQ/ZlrAdLbS', '2024-06-30 17:17:45', '2024-06-22 00:00:00', 3);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `tbcobertura`
--
ALTER TABLE `tbcobertura`
  ADD PRIMARY KEY (`idCobertura`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbconfeitaria`
--
ALTER TABLE `tbconfeitaria`
  ADD PRIMARY KEY (`idConfeitaria`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `tbconversa`
--
ALTER TABLE `tbconversa`
  ADD PRIMARY KEY (`idConversa`),
  ADD KEY `idPrincipal` (`idPrincipal`),
  ADD KEY `idOutro` (`idOutro`);

--
-- Índices de tabela `tbddd`
--
ALTER TABLE `tbddd`
  ADD PRIMARY KEY (`idDDD`);

--
-- Índices de tabela `tbdecoracao`
--
ALTER TABLE `tbdecoracao`
  ADD PRIMARY KEY (`idDecoracao`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbenderecocliente`
--
ALTER TABLE `tbenderecocliente`
  ADD PRIMARY KEY (`idEnderecoCliente`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Índices de tabela `tbformapagamento`
--
ALTER TABLE `tbformapagamento`
  ADD PRIMARY KEY (`idFormaPagamento`);

--
-- Índices de tabela `tbformato`
--
ALTER TABLE `tbformato`
  ADD PRIMARY KEY (`idFormato`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbitenspedido`
--
ALTER TABLE `tbitenspedido`
  ADD PRIMARY KEY (`idItensPedido`),
  ADD KEY `idProduto` (`idProduto`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Índices de tabela `tbmassa`
--
ALTER TABLE `tbmassa`
  ADD PRIMARY KEY (`idMassa`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbmensagem`
--
ALTER TABLE `tbmensagem`
  ADD PRIMARY KEY (`idMensagem`),
  ADD KEY `idRemetente` (`idRemetente`),
  ADD KEY `idDestinatario` (`idDestinatario`);

--
-- Índices de tabela `tbpedido`
--
ALTER TABLE `tbpedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idEnderecoCliente` (`idEnderecoCliente`),
  ADD KEY `idFormaPagamento` (`idFormaPagamento`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Índices de tabela `tbpedidopersonalizado`
--
ALTER TABLE `tbpedidopersonalizado`
  ADD PRIMARY KEY (`idPedidoPersonalizado`),
  ADD KEY `idEnderecoCliente` (`idEnderecoCliente`),
  ADD KEY `idFormaPagamento` (`idFormaPagamento`),
  ADD KEY `idMassa` (`idMassa`),
  ADD KEY `idRecheio` (`idRecheio`),
  ADD KEY `idCobertura` (`idCobertura`),
  ADD KEY `idFormato` (`idFormato`),
  ADD KEY `idDecoracao` (`idDecoracao`),
  ADD KEY `idPersonalizado` (`idPersonalizado`),
  ADD KEY `idCliente` (`idCliente`);

--
-- Índices de tabela `tbpersonalizado`
--
ALTER TABLE `tbpersonalizado`
  ADD PRIMARY KEY (`idPersonalizado`),
  ADD KEY `idPeso` (`idPeso`),
  ADD KEY `idTipoProduto` (`idTipoProduto`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbpeso`
--
ALTER TABLE `tbpeso`
  ADD PRIMARY KEY (`idPeso`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbproduto`
--
ALTER TABLE `tbproduto`
  ADD PRIMARY KEY (`idProduto`),
  ADD KEY `idTipoProduto` (`idTipoProduto`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbrecheio`
--
ALTER TABLE `tbrecheio`
  ADD PRIMARY KEY (`idRecheio`),
  ADD KEY `idConfeitaria` (`idConfeitaria`);

--
-- Índices de tabela `tbsuporte`
--
ALTER TABLE `tbsuporte`
  ADD PRIMARY KEY (`idSuporte`),
  ADD KEY `idTipoSuporte` (`idTipoSuporte`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `tbtelcliente`
--
ALTER TABLE `tbtelcliente`
  ADD PRIMARY KEY (`idTelCliente`),
  ADD KEY `idDDD` (`idDDD`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idTipoTelefone` (`idTipoTelefone`);

--
-- Índices de tabela `tbtelconfeitaria`
--
ALTER TABLE `tbtelconfeitaria`
  ADD PRIMARY KEY (`idTelConfeitaria`),
  ADD KEY `idDDD` (`idDDD`),
  ADD KEY `idConfeitaria` (`idConfeitaria`),
  ADD KEY `idTipoTelefone` (`idTipoTelefone`);

--
-- Índices de tabela `tbtipoproduto`
--
ALTER TABLE `tbtipoproduto`
  ADD PRIMARY KEY (`idTipoProduto`);

--
-- Índices de tabela `tbtiposuporte`
--
ALTER TABLE `tbtiposuporte`
  ADD PRIMARY KEY (`idTipoSuporte`),
  ADD KEY `idTipoUsuario` (`idTipoUsuario`);

--
-- Índices de tabela `tbtipotelefone`
--
ALTER TABLE `tbtipotelefone`
  ADD PRIMARY KEY (`idTipoTelefone`);

--
-- Índices de tabela `tbtipousuario`
--
ALTER TABLE `tbtipousuario`
  ADD PRIMARY KEY (`idTipoUsuario`);

--
-- Índices de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idTipoUsuario` (`idTipoUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tbcliente`
--
ALTER TABLE `tbcliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbcobertura`
--
ALTER TABLE `tbcobertura`
  MODIFY `idCobertura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbconfeitaria`
--
ALTER TABLE `tbconfeitaria`
  MODIFY `idConfeitaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbconversa`
--
ALTER TABLE `tbconversa`
  MODIFY `idConversa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbddd`
--
ALTER TABLE `tbddd`
  MODIFY `idDDD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `tbdecoracao`
--
ALTER TABLE `tbdecoracao`
  MODIFY `idDecoracao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbenderecocliente`
--
ALTER TABLE `tbenderecocliente`
  MODIFY `idEnderecoCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tbformapagamento`
--
ALTER TABLE `tbformapagamento`
  MODIFY `idFormaPagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tbformato`
--
ALTER TABLE `tbformato`
  MODIFY `idFormato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbitenspedido`
--
ALTER TABLE `tbitenspedido`
  MODIFY `idItensPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de tabela `tbmassa`
--
ALTER TABLE `tbmassa`
  MODIFY `idMassa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbmensagem`
--
ALTER TABLE `tbmensagem`
  MODIFY `idMensagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `tbpedido`
--
ALTER TABLE `tbpedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `tbpedidopersonalizado`
--
ALTER TABLE `tbpedidopersonalizado`
  MODIFY `idPedidoPersonalizado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbpersonalizado`
--
ALTER TABLE `tbpersonalizado`
  MODIFY `idPersonalizado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbpeso`
--
ALTER TABLE `tbpeso`
  MODIFY `idPeso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbproduto`
--
ALTER TABLE `tbproduto`
  MODIFY `idProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `tbrecheio`
--
ALTER TABLE `tbrecheio`
  MODIFY `idRecheio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tbsuporte`
--
ALTER TABLE `tbsuporte`
  MODIFY `idSuporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbtelcliente`
--
ALTER TABLE `tbtelcliente`
  MODIFY `idTelCliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tbtelconfeitaria`
--
ALTER TABLE `tbtelconfeitaria`
  MODIFY `idTelConfeitaria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbtipoproduto`
--
ALTER TABLE `tbtipoproduto`
  MODIFY `idTipoProduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `tbtiposuporte`
--
ALTER TABLE `tbtiposuporte`
  MODIFY `idTipoSuporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `tbtipotelefone`
--
ALTER TABLE `tbtipotelefone`
  MODIFY `idTipoTelefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbtipousuario`
--
ALTER TABLE `tbtipousuario`
  MODIFY `idTipoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tbusuario`
--
ALTER TABLE `tbusuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tbcliente`
--
ALTER TABLE `tbcliente`
  ADD CONSTRAINT `tbcliente_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbcobertura`
--
ALTER TABLE `tbcobertura`
  ADD CONSTRAINT `tbcobertura_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbconfeitaria`
--
ALTER TABLE `tbconfeitaria`
  ADD CONSTRAINT `tbconfeitaria_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbconversa`
--
ALTER TABLE `tbconversa`
  ADD CONSTRAINT `tbconversa_ibfk_1` FOREIGN KEY (`idPrincipal`) REFERENCES `tbusuario` (`idUsuario`),
  ADD CONSTRAINT `tbconversa_ibfk_2` FOREIGN KEY (`idOutro`) REFERENCES `tbusuario` (`idUsuario`);

--
-- Restrições para tabelas `tbdecoracao`
--
ALTER TABLE `tbdecoracao`
  ADD CONSTRAINT `tbdecoracao_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbenderecocliente`
--
ALTER TABLE `tbenderecocliente`
  ADD CONSTRAINT `tbenderecocliente_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `tbcliente` (`idCliente`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbformato`
--
ALTER TABLE `tbformato`
  ADD CONSTRAINT `tbformato_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbitenspedido`
--
ALTER TABLE `tbitenspedido`
  ADD CONSTRAINT `tbitenspedido_ibfk_1` FOREIGN KEY (`idProduto`) REFERENCES `tbproduto` (`idProduto`),
  ADD CONSTRAINT `tbitenspedido_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `tbpedido` (`idPedido`);

--
-- Restrições para tabelas `tbmassa`
--
ALTER TABLE `tbmassa`
  ADD CONSTRAINT `tbmassa_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbmensagem`
--
ALTER TABLE `tbmensagem`
  ADD CONSTRAINT `tbmensagem_ibfk_1` FOREIGN KEY (`idRemetente`) REFERENCES `tbusuario` (`idUsuario`),
  ADD CONSTRAINT `tbmensagem_ibfk_2` FOREIGN KEY (`idDestinatario`) REFERENCES `tbusuario` (`idUsuario`);

--
-- Restrições para tabelas `tbpedido`
--
ALTER TABLE `tbpedido`
  ADD CONSTRAINT `tbpedido_ibfk_1` FOREIGN KEY (`idEnderecoCliente`) REFERENCES `tbenderecocliente` (`idEnderecoCliente`),
  ADD CONSTRAINT `tbpedido_ibfk_2` FOREIGN KEY (`idFormaPagamento`) REFERENCES `tbformapagamento` (`idFormaPagamento`),
  ADD CONSTRAINT `tbpedido_ibfk_3` FOREIGN KEY (`idCliente`) REFERENCES `tbcliente` (`idCliente`);

--
-- Restrições para tabelas `tbpedidopersonalizado`
--
ALTER TABLE `tbpedidopersonalizado`
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_1` FOREIGN KEY (`idEnderecoCliente`) REFERENCES `tbenderecocliente` (`idEnderecoCliente`),
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_2` FOREIGN KEY (`idFormaPagamento`) REFERENCES `tbformapagamento` (`idFormaPagamento`),
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_3` FOREIGN KEY (`idMassa`) REFERENCES `tbmassa` (`idMassa`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_4` FOREIGN KEY (`idRecheio`) REFERENCES `tbrecheio` (`idRecheio`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_5` FOREIGN KEY (`idCobertura`) REFERENCES `tbcobertura` (`idCobertura`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_6` FOREIGN KEY (`idFormato`) REFERENCES `tbformato` (`idFormato`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_7` FOREIGN KEY (`idDecoracao`) REFERENCES `tbdecoracao` (`idDecoracao`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_8` FOREIGN KEY (`idPersonalizado`) REFERENCES `tbpersonalizado` (`idPersonalizado`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpedidopersonalizado_ibfk_9` FOREIGN KEY (`idCliente`) REFERENCES `tbcliente` (`idCliente`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbpersonalizado`
--
ALTER TABLE `tbpersonalizado`
  ADD CONSTRAINT `tbpersonalizado_ibfk_1` FOREIGN KEY (`idPeso`) REFERENCES `tbpeso` (`idPeso`),
  ADD CONSTRAINT `tbpersonalizado_ibfk_2` FOREIGN KEY (`idTipoProduto`) REFERENCES `tbtipoproduto` (`idTipoProduto`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbpersonalizado_ibfk_3` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbpeso`
--
ALTER TABLE `tbpeso`
  ADD CONSTRAINT `tbpeso_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbproduto`
--
ALTER TABLE `tbproduto`
  ADD CONSTRAINT `tbproduto_ibfk_1` FOREIGN KEY (`idTipoProduto`) REFERENCES `tbtipoproduto` (`idTipoProduto`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbproduto_ibfk_2` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbrecheio`
--
ALTER TABLE `tbrecheio`
  ADD CONSTRAINT `tbrecheio_ibfk_1` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE;

--
-- Restrições para tabelas `tbsuporte`
--
ALTER TABLE `tbsuporte`
  ADD CONSTRAINT `tbsuporte_ibfk_1` FOREIGN KEY (`idTipoSuporte`) REFERENCES `tbtiposuporte` (`idTipoSuporte`),
  ADD CONSTRAINT `tbsuporte_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`);

--
-- Restrições para tabelas `tbtelcliente`
--
ALTER TABLE `tbtelcliente`
  ADD CONSTRAINT `tbtelcliente_ibfk_1` FOREIGN KEY (`idDDD`) REFERENCES `tbddd` (`idDDD`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbtelcliente_ibfk_2` FOREIGN KEY (`idCliente`) REFERENCES `tbcliente` (`idCliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbtelcliente_ibfk_3` FOREIGN KEY (`idTipoTelefone`) REFERENCES `tbtipotelefone` (`idTipoTelefone`);

--
-- Restrições para tabelas `tbtelconfeitaria`
--
ALTER TABLE `tbtelconfeitaria`
  ADD CONSTRAINT `tbtelconfeitaria_ibfk_1` FOREIGN KEY (`idDDD`) REFERENCES `tbddd` (`idDDD`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbtelconfeitaria_ibfk_2` FOREIGN KEY (`idConfeitaria`) REFERENCES `tbconfeitaria` (`idConfeitaria`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbtelconfeitaria_ibfk_3` FOREIGN KEY (`idTipoTelefone`) REFERENCES `tbtipotelefone` (`idTipoTelefone`);

--
-- Restrições para tabelas `tbtiposuporte`
--
ALTER TABLE `tbtiposuporte`
  ADD CONSTRAINT `tbtiposuporte_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tbtipousuario` (`idTipoUsuario`);

--
-- Restrições para tabelas `tbusuario`
--
ALTER TABLE `tbusuario`
  ADD CONSTRAINT `tbusuario_ibfk_1` FOREIGN KEY (`idTipoUsuario`) REFERENCES `tbtipousuario` (`idTipoUsuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
