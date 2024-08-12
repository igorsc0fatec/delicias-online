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

include_once '../controller/controller-pedido.php';
$controllerPedido = new ControllerPedido();

if (isset($_GET['action']) && $_GET['action'] == 'fetch_pedidos') {
    $pedidos = $controllerPedido->getPedidosByCliente($_SESSION['idCliente']);
    header('Content-Type: application/json');
    echo json_encode($pedidos);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'cancel_pedido') {
    $idPedido = $_POST['idPedido'];
    $success = $controllerPedido->cancelarPedido();
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

        .status-cancelado {
            color: #8B0000;
            /* Vermelho escuro */
        }
    </style>
    <title>Meus Pedidos - Delicia Online</title>
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
            <h1>Meus Pedidos</h1>
        </div>
        <div id="pedidos-list" class="pedidos-list"></div>
    </div>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function loadPedidos() {
                $.ajax({
                    url: 'meus-pedidos.php?action=fetch_pedidos',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var pedidosList = $('#pedidos-list');
                        pedidosList.empty();
                        data.forEach(function (pedido) {
                            var statusClass = (pedido.pedido.status.toLowerCase() === 'cancelado') ? 'status-cancelado' : '';
                            var cancelarBtnDisabled = (pedido.pedido.status.toLowerCase() === 'cancelado') ? 'disabled' : '';
                            var pedidoItem = `
                        <div class="pedido-item">
                            <div class="info-box pedido-info">
                                <h2>Informações do Pedido</h2>
                                <p><strong>ID do Pedido:</strong> ${pedido.pedido.idPedido}</p>
                                <p><strong>Valor Total:</strong> R$ ${parseFloat(pedido.pedido.valorTotal).toFixed(2).replace('.', ',')}</p>
                                <p><strong>Desconto:</strong> R$ ${parseFloat(pedido.pedido.desconto).toFixed(2).replace('.', ',')}</p>
                                <p><strong>Data do Pedido:</strong> ${pedido.pedido.dataPedido}</p>
                                <p><strong>Hora do Pedido:</strong> ${pedido.pedido.horaPedido}</p>
                                <p><strong>Frete:</strong> R$ ${parseFloat(pedido.pedido.frete).toFixed(2).replace('.', ',')}</p>
                                <p><strong>Forma de Pagamento:</strong> ${pedido.pedido.formaPagamento}</p>
                                <p><strong>Endereço de Entrega:</strong> ${pedido.pedido.logCliente}, ${pedido.pedido.numLocal}, ${pedido.pedido.bairroCliente}, ${pedido.pedido.cidadeCliente}, ${pedido.pedido.ufCliente}, ${pedido.pedido.cepCliente}</p>
                                <p class="${statusClass}"><strong>Status do pedido:</strong> ${pedido.pedido.status}</p>
                            </div>
                            <form method="post">
                                <input type="hidden" name="idPedido" value="${pedido.pedido.idPedido}">
                                <button class="cancelar-btn" name="cancel" ${cancelarBtnDisabled} onclick="cancelarPedido(${pedido.pedido.idPedido})">Cancelar Pedido</button>
                            </form>
                            <div class="info-box itens-info">
                                <h2>Itens do Pedido</h2>`;
                            pedido.itens.forEach(function (item) {
                                pedidoItem += `
                                    <div class="item">
                                        <img src="../view-confeitaria/${item.imgProduto}" alt="${item.nomeProduto}" class="item-img">
                                        <div>
                                            <p class="item-title">Nome do Produto: ${item.nomeProduto}</p>
                                            <p>Quantidade: ${item.quantidade}</p>
                                        </div>
                                    </div>`;
                            });
                            pedidoItem += `
                            </div>
                            <a href="nota-fiscal.php?idPedido=${pedido.pedido.idPedido}" class="ver-nota-btn">Ver Nota Fiscal</a>
                        </div>`;
                            pedidosList.append(pedidoItem);
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            loadPedidos();
        });

        function cancelarPedido(idPedido) {
            event.preventDefault();
            $.ajax({
                url: 'meus-pedidos.php',
                type: 'POST',
                data: { action: 'cancel_pedido', idPedido: idPedido },
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
                            text: 'O pedido já está em rota de entrega!',
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