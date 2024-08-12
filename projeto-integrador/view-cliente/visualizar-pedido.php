<?php
session_start();

// Verifica se o usuário está logado como cliente
if (!isset($_SESSION['idCliente'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
} else if (isset($_SESSION['idTipoUsuario'])) {
    if ($_SESSION['idTipoUsuario'] != 2) {
        echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    }
}

include_once '../controller/controller-pedido.php';

$controllerPedido = new ControllerPedido();
$idPedido = $_GET['i'] ?? null;

// Verifica se o ID do pedido foi fornecido
if (!$idPedido) {
    echo "ID do pedido não fornecido.";
    exit();
}

$pedidoData = $controllerPedido->viewPedido($idPedido);
$pedido = $pedidoData['pedido'][0] ?? null;
$itens = $pedidoData['itens'] ?? [];

// Verifica se o pedido foi encontrado
if (!$pedido) {
    echo "Pedido não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <link rel="stylesheet" href="assets/css/style-pedido.css">
    <title>Detalhes do Pedido - Delicia Online</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav-container">
                <a href="dashboard-cliente.php">
                    <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                </a>
                <i class="fas fa-bars btn-menumobile"></i>
                <ul>
                    <li><a href="dashboard-cliente.php">Home</a></li>
                    <li><a href="meus-pedidos.php">Meus Pedidos</a></li>
                    <li><a href="editar-cliente.php">Meus Dados</a></li>
                    <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <div class="container">
        <!-- Título da página -->
        <div class="header">
            <h1>Detalhes do Pedido</h1>
        </div>

        <!-- Informações do cliente -->
        <div class="info-box cliente-info">
            <h2>Seus dados</h2>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($pedido['nomeCliente']); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($pedido['cpfCliente']); ?></p>
        </div>

        <div class="info-section">
            <!-- Informações do pedido -->
            <div class="info-box pedido-info">
                <h2>Informações do Pedido</h2>
                <p><strong>ID do Pedido:</strong> <?php echo htmlspecialchars($pedido['idPedido']); ?></p>
                <p><strong>Valor Total:</strong> R$ <?php echo number_format($pedido['valorTotal'], 2, ',', '.'); ?></p>
                <p><strong>Desconto:</strong> R$ <?php echo number_format($pedido['desconto'], 2, ',', '.'); ?></p>
                <p><strong>Data do Pedido:</strong> <?php echo htmlspecialchars($pedido['dataPedido']); ?></p>
                <p><strong>Hora do Pedido:</strong> <?php echo htmlspecialchars($pedido['horaPedido']); ?></p>
                <p><strong>Frete:</strong> R$ <?php echo number_format($pedido['frete'], 2, ',', '.'); ?></p>
                <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($pedido['formaPagamento']); ?></p>
                <p><strong>Endereço de Entrega:</strong>
                    <?php echo htmlspecialchars($pedido['logCliente']) . ', ' . htmlspecialchars($pedido['numLocal']) . ', ' . htmlspecialchars($pedido['bairroCliente']) . ', ' .
                        htmlspecialchars($pedido['cidadeCliente']) . ', ' . htmlspecialchars($pedido['ufCliente']) . ', ' . htmlspecialchars($pedido['cepCliente']); ?>
                </p>
                <p><strong>Status do pedido:</strong> <?php echo htmlspecialchars($pedido['status']); ?></p>
            </div>

            <!-- Itens do pedido -->
            <div class="info-box itens-info">
                <h2>Itens do Pedido</h2>
                <?php foreach ($itens as $item){ ?>
                    <div class="item">
                        <img src="<?php echo '../view-confeitaria/' . $item['imgProduto']; ?>"
                             alt="<?php echo htmlspecialchars($item['nomeProduto']); ?>" class="item-img">
                        <div>
                            <p class="item-title">Nome do Produto: <?php echo htmlspecialchars($item['nomeProduto']); ?></p>
                            <p>Quantidade: <?php echo htmlspecialchars($item['quantidade']); ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>
</body>
</html>
