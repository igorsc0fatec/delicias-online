<?php
session_start();
if (!isset($_SESSION['idConfeitaria'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-confeitaria.php'</script>";
} else if (isset($_SESSION['idTipoUsuario'])) {
    if ($_SESSION['idTipoUsuario'] != 3) {
        echo "<script language='javascript' type='text/javascript'> window.location.href='login-confeitaria.php'</script>";
    }
}

include_once '../controller/controller-pedido.php';

$controllerPedido = new ControllerPedido();

$idConfeitaria = $_SESSION['idConfeitaria'];

$termoPesquisa = '';
if (isset($_GET['termo'])) {
    $termoPesquisa = $_GET['termo'];
    $pedidos = $controllerPedido->buscarPedidosConfeitaria($idConfeitaria, $termoPesquisa);
} else {
    $pedidos = $controllerPedido->getPedidosConfeitaria($idConfeitaria);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirmar']) && isset($_POST['idPedido'])) {
        $controllerPedido->confirmarPedido($_POST['idPedido']);
        echo "<script language='javascript' type='text/javascript'> window.location.href='pedidos.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style_home.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <style>
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .pedido-info,
        .itens-info,
        .cliente-info {
            margin-bottom: 20px;
        }

        .pedido-info h2,
        .itens-info h2,
        .cliente-info h2 {
            margin-bottom: 10px;
        }

        .item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-title {
            font-weight: bold;
        }

        .item-image {
            max-width: 100px;
            max-height: 100px;
            margin-right: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }

        .btn-detalhes,
        .btn-confirmar,
        .btn-cancelar {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            font-size: 1.2em;
            cursor: pointer;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-detalhes:hover,
        .btn-confirmar:hover,
        .btn-cancelar:hover {
            background-color: #45a049;
        }

        .btn-confirmar {
            background-color: #008CBA;
        }

        .btn-cancelar {
            background-color: #f44336;
        }

        .btn-cancelar:hover {
            background-color: #d32f2f;
        }

        .search-bar {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 80%;
            font-size: 1em;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: #45a049;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Delicia Online</title>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-confeitaria.php">
                        <img id="logo" src="assets/img/logo.png" alt="Delicia Online">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="meus-produtos.php">Meus Produtos</a></li>
                        <li><a href="meus-contatos.php">Chat</a></li>
                        <li><a href="pedidos.php">Pedidos</a></li>
                        <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                        <li><a href="editar-confeitaria.php">Meus Dados</a></li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <div>
        <br><br><br><br><br><br>
    </div>

    <div class="container">
        <div class="header">
            <h1>Pedidos Recebidos!</h1>
        </div>

        <div class="search-bar">
            <form action="" method="get">
                <input type="text" name="termo" placeholder="Buscar por ID do pedido ou status"
                    value="<?php echo htmlspecialchars($termoPesquisa); ?>">
                <button type="submit">Buscar</button>
            </form>
        </div>

        <?php if (empty($pedidos)): ?>
            <p>Não há pedidos no momento.</p>
        <?php else: ?>
            <?php
            $currentPedidoId = null;
            foreach ($pedidos as $pedido):
                if ($pedido['idPedido'] !== $currentPedidoId):
                    if ($currentPedidoId !== null): ?>
                        <form action="" method="post">
                            <input type="hidden" name="idPedido" value="<?php echo htmlspecialchars($currentPedidoId); ?>">
                            <button type="submit" name="confirmar" class="btn-confirmar">Confirmar Pedido</button>
                        </form>
                    </div>
                <?php endif; ?>
                <div class="pedido-info">
                    <h2>Pedido Nº <?php echo htmlspecialchars($pedido['idPedido']); ?></h2>
                    <p><strong>Data do Pedido:</strong> <?php echo date('d/m/Y', strtotime($pedido['dataPedido'])); ?></p>
                    <p><strong>Hora do Pedido:</strong> <?php echo htmlspecialchars($pedido['horaPedido']); ?></p>
                    <p><strong>Status do Pedido:</strong> <?php echo htmlspecialchars($pedido['status']); ?></p>
                    <p><strong>Valor Total:</strong> R$ <?php echo number_format($pedido['valorTotal'], 2, ',', '.'); ?></p>
                    <p><strong>Forma de Pagamento:</strong> <?php echo htmlspecialchars($pedido['formaPagamento']); ?></p>
                    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['nomeCliente']); ?></p>
                    <h3>Itens do Pedido</h3>
                    <?php
                    $currentPedidoId = $pedido['idPedido'];
                endif;
                ?>
                <div class="item">
                    <div>
                        <p class="item-title">Nome do Produto: <?php echo htmlspecialchars($pedido['nomeProduto']); ?></p>
                        <p>Descrição: <?php echo htmlspecialchars($pedido['descProduto']); ?></p>
                        <p>Quantidade: <?php echo htmlspecialchars($pedido['quantidade']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <form action="" method="post">
                <input type="hidden" name="idPedido" value="<?php echo htmlspecialchars($currentPedidoId); ?>">
                <button type="submit" name="confirmar" class="btn-confirmar">Confirmar Pedido</button>
            </form>
        </div>
    <?php endif; ?>
    </div>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>
</body>

</html>