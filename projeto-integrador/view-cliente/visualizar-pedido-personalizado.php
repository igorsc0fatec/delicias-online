<?php
session_start();
if (!isset($_SESSION['idCliente'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
} else if (isset($_SESSION['idTipoUsuario'])) {
    if ($_SESSION['idTipoUsuario'] != 2) {
        echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    }
}

include_once '../controller/controller-pedido-personalizado.php';

$controllerPedido = new ControllerPedidoPersonalizado();

$idPedido = $_GET['i'] ?? null;
if (!$idPedido) {
    echo "ID do pedido não fornecido.";
    exit();
}

$pedidoData = $controllerPedido->viewPedidoPersonalizado($idPedido);
$pedido = $pedidoData[0] ?? null;

if (!$pedido) {
    echo "Pedido não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Pedido - Delicia Online</title>
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
            position: relative;
        }

        .chat-button {
            position: absolute;
            top: 0;
            right: 0;
            margin: 20px;
            padding: 10px 20px;
            font-size: 1.2em;
            cursor: pointer;
            border: none;
            background-color: #ff5722;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .chat-button:hover {
            background-color: #e64a19;
        }

        .pedido-info,
        .itens-info,
        .cliente-info,
        .confeitaria-info {
            margin-bottom: 20px;
        }

        .pedido-info h2,
        .itens-info h2,
        .cliente-info h2,
        .confeitaria-info h2 {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-cliente.php">
                        <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="dashboard-cliente.php">Adicionar Produtos</a></li>
                        <li><a href="#">Confeitarias</a></li>
                        <li><a href="#">Suporte</a></li>
                        <li><a href="editar-cliente.php">Meus Dados</a></li>
                        <li><a href="carrinho.php">Carrinho</a></li>
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
            <h1>Detalhes do Pedido</h1>
            <a href="chat-cliente.php?c=<?php echo htmlspecialchars($pedido['idConfeitaria']); ?>" class="chat-button">Iniciar Chat</a>
        </div>

        <div class="cliente-info">
            <h2>Informações do Cliente</h2>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($pedido['nomeCliente']); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($pedido['cpfCliente']); ?></p>
        </div>

        <div class="pedido-info">
            <h2>Informações do Pedido</h2>
            <p><strong>ID do Pedido:</strong> <?php echo htmlspecialchars($pedido['idPedidoPersonalizado']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($pedido['status']); ?></p>
            <p><strong>Data do Pedido:</strong> <?php echo htmlspecialchars($pedido['dataPedido']); ?></p>
            <p><strong>Hora do Pedido:</strong> <?php echo htmlspecialchars($pedido['horaPedido']); ?></p>
        </div>

        <div class="itens-info">
            <h2>Itens do Pedido</h2>
            <p><strong>Massa:</strong> <?php echo htmlspecialchars($pedido['descMassa']); ?></p>
            <p><strong>Recheio:</strong> <?php echo htmlspecialchars($pedido['descRecheio']); ?></p>
            <p><strong>Cobertura:</strong> <?php echo htmlspecialchars($pedido['descCobertura']); ?></p>
            <p><strong>Formato:</strong> <?php echo htmlspecialchars($pedido['descFormato']); ?></p>
            <p><strong>Decoração:</strong> <?php echo htmlspecialchars($pedido['descDecoracao']); ?></p>
            <p><strong>Personalização:</strong> <?php echo htmlspecialchars($pedido['nomePersonalizado']); ?></p>
        </div>

        <div class="confeitaria-info">
            <h2>Confeitaria</h2>
            <p><strong>Nome da Confeitaria:</strong> <?php echo htmlspecialchars($pedido['nomeConfeitaria']); ?></p>
        </div>

        <p>Nota: Os valores relacionados a este pedido ainda não foram definidos. Por favor, entre em contato com a confeitaria para finalizar o pedido.</p>
    </div>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>
</body>
</html>
