<?php
session_start();

if (!isset($_SESSION['idCliente'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    exit();
} else if (isset($_SESSION['idTipoUsuario']) && $_SESSION['idTipoUsuario'] != 2) {
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    exit();
}

include_once '../controller/controller-pedido-personalizado.php';
$controllerPedido = new ControllerPedidoPersonalizado();

if (isset($_GET['action']) && $_GET['action'] == 'fetch_pedidos_personalizados') {
    $pedidosPersonalizados = $controllerPedido->getPedidosPersonalizadosByCliente($_SESSION['idCliente']);
    header('Content-Type: application/json');
    echo json_encode($pedidosPersonalizados);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'cancel_pedido_personalizado') {
    $idPedidoPersonalizado = $_POST['idPedidoPersonalizado'];
    $success = $controllerPedido->cancelarPedidoPersonalizado();
    header('Content-Type: application/json');
    echo json_encode(['success' => $success]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <link rel="stylesheet" href="assets/css/style-pedido.css">
    <style>
        .pedido-item {
            position: relative;
            margin-bottom: 20px;
        }

        .cancelar-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .ver-nota-btn {
            display: block;
            width: fit-content;
            background-color: #6c63ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .ver-nota-btn:hover {
            background-color: #564fd9;
        }
    </style>
    <title>Pedidos Personalizados - Delicia Online</title>
</head>

<body>
    <header>
        <nav>
            <div class="nav-container">
                <a href="dashboard-cliente.php">
                    <img id="logo" src="assets/img/logo.png" alt="Delicia Online">
                </a>
                <i class="fas fa-bars btn-menumobile"></i>
                <ul>
                    <li><a href="dashboard-cliente.php">Home</a></li>
                    <li><a href="meus-pedidos.php">Meus Pedidos</a></li>
                    <li><a href="pedidos-personalizados.php">Pedidos Personalizados</a></li>
                    <li><a href="editar-cliente.php">Meus Dados</a></li>
                    <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="header">
            <h1>Pedidos Personalizados</h1>
        </div>

        <div id="pedidos-personalizados-list" class="pedidos-list"></div>
    </div>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function loadPedidosPersonalizados() {
                $.ajax({
                    url: 'pedidos-personalizados.php?action=fetch_pedidos_personalizados',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var pedidosList = $('#pedidos-personalizados-list');
                        pedidosList.empty();
                        data.forEach(function (pedido) {
                            var pedidoItem = `
                                <div class="pedido-item">
                                    <div class="info-box pedido-info">
                                        <h2>Informações do Pedido</h2>
                                        <p><strong>ID do Pedido:</strong> ${pedido.idPedidoPersonalizado}</p>
                                        <p><strong>Valor Total:</strong> R$ ${parseFloat(pedido.valorTotal).toFixed(2).replace('.', ',')}</p>
                                        <p><strong>Desconto:</strong> R$ ${parseFloat(pedido.desconto).toFixed(2).replace('.', ',')}</p>
                                        <p><strong>Data do Pedido:</strong> ${pedido.dataPedido}</p>
                                        <p><strong>Hora do Pedido:</strong> ${pedido.horaPedido}</p>
                                        <p><strong>Frete:</strong> R$ ${parseFloat(pedido.frete).toFixed(2).replace('.', ',')}</p>
                                        <p><strong>Status do pedido:</strong> ${pedido.status}</p>
                                    </div>
                                    <form method="post">
                                        <input type="hidden" name="idPedidoPersonalizado" value="${pedido.idPedidoPersonalizado}">
                                        <button class="cancelar-btn" name="cancel" onclick="cancelarPedidoPersonalizado(${pedido.idPedidoPersonalizado})">Cancelar Pedido</button>
                                    </form>
                                    <div class="info-box itens-info">
                                        <h2>Detalhes do Pedido Personalizado</h2>
                                        <p><strong>Massa:</strong> ${pedido.descMassa}</p>
                                        <p><strong>Recheio:</strong> ${pedido.descRecheio}</p>
                                        <p><strong>Cobertura:</strong> ${pedido.descCobertura}</p>
                                        <p><strong>Formato:</strong> ${pedido.descFormato}</p>
                                        <p><strong>Decoração:</strong> ${pedido.descDecoracao}</p>
                                        <p><strong>Nome Personalizado:</strong> ${pedido.nomePersonalizado}</p>
                                        <p><strong>Descrição Personalizada:</strong> ${pedido.descPersonalizado}</p>
                                        <div class="item">
                                            <img src="../view-confeitaria/${pedido.imgPersonalizado}" alt="${pedido.nomePersonalizado}" class="item-img">
                                            <div>
                                                <p class="item-title">Quantidade: ${pedido.qtdPersonalizado}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="nota-fiscal-personalizada.php?idPedidoPersonalizado=${pedido.idPedidoPersonalizado}" class="ver-nota-btn">Ver Nota Fiscal</a>
                                </div>`;
                            pedidosList.append(pedidoItem);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            loadPedidosPersonalizados();
        });

        function cancelarPedidoPersonalizado(idPedidoPersonalizado) {
            event.preventDefault();
            $.ajax({
                url: 'pedidos-personalizados.php',
                type: 'POST',
                data: { action: 'cancel_pedido_personalizado', idPedidoPersonalizado: idPedidoPersonalizado },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Pedido cancelado com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Erro ao cancelar o pedido!',
                            text: 'O pedido já está em produção!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Erro ao cancelar o pedido!',
                        text: 'Ocorreu um erro inesperado.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }
    </script>
</body>

</html>