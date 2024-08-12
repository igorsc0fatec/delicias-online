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
include_once '../controller/controller-personalizado.php';
$produtoController = new ControllerPedidoPersonalizado();
$personalizadoController = new ControllerPersonalizado();

$idConfeitaria = $_GET['c'];
$idPersonalizado = $_GET['p'];

$coberturas = $produtoController->viewCobertura($idConfeitaria);
$decoracoes = $produtoController->viewDecoracao($idConfeitaria);
$formatos = $produtoController->viewFormato($idConfeitaria);
$massas = $produtoController->viewMassa($idConfeitaria);
$recheios = $produtoController->viewRecheio($idConfeitaria);
$personalizado = $personalizadoController->viewDadosPersonalizado($_GET['p']);
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
    <link rel="stylesheet" href="assets/css/style copy.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicia online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .product-image img {
            max-width: 300px;
            border-radius: 8px;
        }

        .product-details {
            text-align: center;
        }

        .product-details h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .product-details p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #666;
        }

        .product-details .price,
        .product-details .frete {
            font-size: 18px;
            margin-bottom: 20px;
            color: #e74c3c;
        }

        .form-container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container .input-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container .input-box {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-container .input-box label {
            font-size: 14px;
            color: #333;
        }

        .form-container .input-box select,
        .form-container .input-box p {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f4f4f4;
        }

        .form-container .continue-button {
            display: flex;
            justify-content: center;
        }

        .form-container .continue-button button {
            background-color: #8e44ad;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container .continue-button button:hover {
            background-color: #732d91;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="nav-container">
                <a href="dashboard-cliente.php">
                    <img id="logo" src="assets/img/logo.png" alt="Delicia Online" style="height: 40px;">
                </a>
                <ul>
                    <li><a href="#">Pedir Produtos</a></li>
                    <li><a href="#">Confeitarias</a></li>
                    <li><a href="#">Suporte</a></li>
                    <li><a href="editar-cliente.php">Meus Dados</a></li>
                    <li><a href="dashboard-cliente.php">Home</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div>
        <br><br><br><br><br><br>
    </div>

    <?php if (empty($coberturas) || empty($decoracoes) || empty($formatos) || empty($massas) || empty($recheios) || empty($personalizado)) {
        echo "<script>
                    Swal.fire({
                        title: 'Essa Confeitaria não disponibilizou dados o suficiente!',
                        icon: 'info',
                        confirmButtonText: 'OK',
                            didClose: () => {
                                window.location.href = 'dashboard-cliente.php?';
                    }
                            });
            </script>";
    } ?>

    <div class="container">
        <div class="product-container">
            <?php foreach ($personalizado as $perso) { ?>
                <div class="product-image">
                    <?php
                    $imagemBase64 = base64_encode($perso['imgPersonalizado']);
                    echo "<img name='imgPersonalizado' src='data:image/jpeg;base64,$imagemBase64'>";
                    ?>
                </div>
                <div class="product-details">
                    <h1><?php echo $perso['nomePersonalizado'] ?></h1>
                    <p><?php echo $perso['descPersonalizado'] ?></p>
                </div>
            <?php } ?>
        </div>

        <div class="form-container">
            <form enctype="multipart/form-data" method="post" onsubmit="return validaProduto()">
                <div class="form-header">
                    <div class="title">
                        <h2>Personalize seu Pedido</h2>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="descCobertura">Cobertura:</label>
                        <select id="descCobertura" name="descCobertura">
                            <?php foreach ($coberturas as $cobertura): ?>
                                <option value="<?php echo $cobertura['idCobertura']; ?>">
                                    <?php echo $cobertura['descCobertura'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="descDecoracao">Decoração:</label>
                        <select id="descDecoracao" name="descDecoracao">
                            <?php foreach ($decoracoes as $decoracao): ?>
                                <option value="<?php echo $decoracao['idDecoracao']; ?>">
                                    <?php echo $decoracao['descDecoracao'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="descFormato">Formato:</label>
                        <select id="descFormato" name="descFormato">
                            <?php foreach ($formatos as $formato): ?>
                                <option value="<?php echo $formato['idFormato']; ?>">
                                    <?php echo $formato['descFormato'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="descMassa">Massa:</label>
                        <select id="descMassa" name="descMassa">
                            <?php foreach ($massas as $massa): ?>
                                <option value="<?php echo $massa['idMassa']; ?>"><?php echo $massa['descMassa'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="descRecheio">Recheio:</label>
                        <select id="descRecheio" name="descRecheio">
                            <?php foreach ($recheios as $recheio): ?>
                                <option value="<?php echo $recheio['idRecheio']; ?>"><?php echo $recheio['descRecheio'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" id="idPersonalizado" name="idPersonalizado" value="<?php echo $_GET['p'] ?>">
                </div>

                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Enviar Pedido</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $idPedidoPersonalizado = $produtoController->addPedidoPersonalizado();
        if ($idPedidoPersonalizado) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Pedido feito com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    didClose: () => {
                        window.location.href = 'visualizar-pedido-personalizado.php?i=$idPedidoPersonalizado';
                    }
                    });
                </script>";
        } else {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao fazer o pedido!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        }
    }
    ?>

    <footer>
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>
</body>

</html>