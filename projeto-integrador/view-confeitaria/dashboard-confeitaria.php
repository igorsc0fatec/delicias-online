<?php
session_start();
include_once '../controller/controller-usuario.php';
$usuarioController = new ControllerUsuario();

if (isset($_SESSION['emailUsuario'])) {
    if (isset($_SESSION['idTipoUsuario'])) {
        if ($_SESSION['idTipoUsuario'] != 3) {
            session_destroy();
            echo "<script language='javascript' type='text/javascript'> window.location.href='login-confeitaria.php'</script>";
        }
    } else {
        $usuarioController->armazenaSessao(3, $_SESSION['emailUsuario']);
    }
} else {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-confeitaria.php'</script>";
}

include_once '../controller/controller-pedido.php';
include_once '../controller/controller-pedido-personalizado.php';
$controllerPedido = new ControllerPedido();
$controllerPersonalizado = new ControllerPedidoPersonalizado();

$pedidos = $controllerPedido->getPedidosByConfeitaria();
$pedidosPersonalizados = $controllerPersonalizado->getPersonalizadosByConfeitaria();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idPedido'])) {
    $idPedido = $_POST['idPedido'];
    $controllerPedido->iniciarEntrega($idPedido);
}

$produtosNormaisMaisVendidos = $controllerPedido->getProdutosNormaisMaisVendidos();
$produtosPersonalizadosMaisVendidos = $controllerPedido->getProdutosPersonalizadosMaisVendidos();
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
    <link rel="stylesheet" href="assets/css/style-menu.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicia Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            padding: 15px 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .nav-container a {
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            margin-left: 20px;
        }

        .btn-menumobile {
            display: none;
            font-size: 24px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .table-container {
            margin-bottom: 40px;
        }

        h2 {
            margin-top: 40px;
            font-size: 24px;
            color: #333333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .button-container {
            text-align: right;
        }

        .btn-action {
            background-color: #8e44ad;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-action:hover {
            background-color: #732d91;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-image img {
            width: 100%;
            height: auto;
        }

        .card-text {
            padding: 15px;
        }

        .card-title {
            font-size: 20px;
            margin: 0 0 10px;
        }

        .card-body {
            font-size: 16px;
            color: #666666;
        }

        .card-price {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }

        #header {
            text-align: center;
            margin: 40px 0;
        }

        #header h1 {
            font-size: 32px;
            color: #333333;
        }

        .nav-container ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .nav-container ul li {
            margin: 0 10px;
        }

        .nav-container ul li form {
            display: inline;
        }

        #container_ajuda {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 40px;
        }

        #container_ajuda h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #container_ajuda p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .btn-menumobile {
                display: block;
            }

            .nav-container ul {
                display: none;
                flex-direction: column;
                background-color: #343a40;
                position: absolute;
                top: 60px;
                right: 20px;
                width: 200px;
            }

            .nav-container ul li {
                margin: 10px 0;
                text-align: right;
                padding-right: 20px;
            }

            .nav-container ul.show {
                display: flex;
            }
        }

        .scrollable-table {
            max-height: 400px;
            overflow-y: auto;
        }

        .scrollable-table-conditional {
            max-height: none;
            overflow-y: visible;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('.btn-menumobile').click(function () {
                $('nav ul').toggleClass('show');
            });

            // Função para aplicar rolagem condicionalmente
            function applyScrollableTable(tableSelector) {
                var table = $(tableSelector);
                var rows = table.find('tbody tr').length;

                if (rows > 5) {
                    table.closest('.table-container').addClass('scrollable-table');
                } else {
                    table.closest('.table-container').addClass('scrollable-table-conditional');
                }
            }

            applyScrollableTable('.container table:eq(0)');
            applyScrollableTable('.container table:eq(1)');
        });

        function mostrarParagrafo2() {
            $('#paragrafo2').toggle();
        }

        function mostrarParagrafo3() {
            $('#paragrafo3').toggle();
        }

        function mostrarParagrafo4() {
            $('#paragrafo4').toggle();
        }
    </script>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="../view/index.php">
                        <img id="logo" src="assets/img/logo.png" alt="Delicia Online">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="meus-produtos.php">Meus Produtos</a></li>
                        <li><a href="meus-contatos.php"><i class='fas fa-comments'
                                    style='font-size:20px'></i> Chat</a></li>
                        <li><a href="pedidos.php">Pedidos</a></li>
                        <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                        <li><a href="editar-confeitaria.php">Meus Dados</a></li>
                        <li>
                            <form action="../view/logout.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['idUsuario'] ?>">
                                <button type="submit" class="fa fa-logout logado"><i class="fa fa-sign-out"
                                        style="font-size:20px"></i></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <br><br><br><br>

    <div id="header">
        <h1>Últimos Pedidos</h1>
    </div>

    <div class="container table-container">
        <h2>Pedidos Normais</h2>
        <div class="scrollable-table">
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Hora</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pedidos as $pedido) {
                        echo '
                    <tr>
                        <td>' . $pedido['idPedido'] . '</td>
                        <td>' . $pedido['nomeCliente'] . '</td>
                        <td>' . $pedido['horaPedido'] . '</td>
                        <td>' . $pedido['dataPedido'] . '</td>
                        <td>' . 'R$ ' . $pedido['valorTotal'] . '</td>
                        <td class="button-container">
                            <form method="post" action="">
                                <input type="hidden" name="idPedido" value="' . $pedido['idPedido'] . '">
                                <button type="submit" class="btn-action">Iniciar Entrega</button>
                            </form>
                        </td>
                    </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container table-container">
        <h2>Pedidos Personalizados</h2>
        <div class="scrollable-table">
            <table>
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pedidosPersonalizados as $pedido) {
                        echo '
                            <tr>
                                <td>' . $pedido['idPedidoPersonalizado'] . '</td>
                                <td>' . $pedido['nomeCliente'] . '</td>
                                <td>' . $pedido['horaPedido'] . '</td>
                                <td>' . $pedido['dataPedido'] . '</td>
                                <td class="button-container"><a class="btn-action" href="chat-confeitaria.php?u=' . $pedido['idUsuario'] . '">Iniciar Chat</a></td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="header">
        <h1>Produtos Mais Vendidos</h1>
    </div>

    <div class="container table-container">
        <h2>Produtos Normais Mais Vendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade Vendida</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($produtosNormaisMaisVendidos as $produto) {
                    echo '
                    <tr>
                        <td>' . $produto['nomeProduto'] . '</td>
                        <td>' . $produto['totalVendido'] . '</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container table-container">
        <h2>Produtos Personalizados Mais Vendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome do Produto</th>
                    <th>Quantidade Vendida</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($produtosPersonalizadosMaisVendidos as $produto) {
                    echo '
                    <tr>
                        <td>' . $produto['nomePersonalizado'] . '</td>
                        <td>' . $produto['totalVendido'] . '</td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="container_ajuda">
        <h2>Ajuda</h2>
        <p>Se precisar de assistência, Aqui tem algumas perguntas frequentes.</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo2()"> 1 - Este Site é seguro?</p>

        <p id="paragrafo2" style="display: none;"><br>Todas as transações são criptografadas para garantir segurança.
        </p>
        <p>__________________________________________________________________________</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo3()"> 2 - Como aplicar cupons de desconto?</p>

        <p id="paragrafo3" style="display: none;"><br>Durante o checkout, há uma opção para inserir o código do cupom.
        </p>
        <p>__________________________________________________________________________</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo4()"> 3 - Participação em promoções específicas?</p>

        <p id="paragrafo4" style="display: none;"><br>Fique atento às nossas newsletters e redes sociais para
            informações sobre promoções
            especiais.</p>
        <p>__________________________________________________________________________</p>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
</body>

</html>