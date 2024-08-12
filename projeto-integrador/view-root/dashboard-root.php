<?php
session_start();
include_once '../controller/controller-usuario.php';
$usuarioController = new ControllerUsuario();

if (isset($_SESSION['emailUsuario'])) {
    if (isset($_SESSION['idTipoUsuario'])) {
        if ($_SESSION['idTipoUsuario'] != 1) {
            session_destroy();
            echo "<script language='javascript' type='text/javascript'> window.location.href='../view/index.php'</script>";
        }
    } else {
        $usuarioController->armazenaSessao(1, $_SESSION['emailUsuario']);
    }
} else {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='../view/index.php'</script>";
}

$clientes = $usuarioController->viewSuporteCliente();
$confeitarias = $usuarioController->viewSuporteConfeitaria();

if (isset($_POST['resolvido'])) {
    $usuarioController->enviarFeedback();
}

if (isset($_POST['pesq_cliente'])) {
    $clientes = $usuarioController->pesquisarSuporte(2);
}

if (isset($_POST['pesq_confeitaria'])) {
    $confeitarias = $usuarioController->pesquisarSuporte(3);
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
    <link rel="stylesheet" href="assets/css/style_prod_01.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delicia online</title>

</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-root.php">
                        <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="Clientes-root.php" target="_blank">Clientes</a></li>
                        <li><a href="Confeitarias-root.php" target="_blank">Confeitarias</a></li>
                        <li><a href="cadastrar-root.php">Novo Adm</a></li>
                        <li>
                            <form action="../view/logout.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['idRoot'] ?>">
                                <button type="submit"><i class="fa fa-sign-out" style="font-size:20px"></i></button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <div>
        <form method="post">
            <div class="pesquisa">
                <label for="pesq">Buscar Nome do Cliente:</label>
                <div class="input-wrapper">
                    <input id="pesq" type="text" name="pesq" placeholder="Pesquise aqui:" required>
                    <button type="submit" id="pesq_cliente" name="pesq_cliente">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <br><br>

    <div>
        <h1>Reclamações de Clientes </h1>
        <div class="tabela-scroll">
            <table id="minhaTabela">
                <tr>
                    <th>
                        <center>ID</center>
                    </th>
                    <th>
                        <center>Nome do Cliente</center>
                    </th>
                    <th>
                        <center>Titulo</center>
                    </th>
                    <th>
                        <center>Descrição</center>
                    </th>
                    <th>
                        <center>Tipo de Suporte</center>
                    </th>
                    <th>
                        <center>ID de Usuario</center>
                    </th>
                    <th>
                        <center>Resolução</center>
                    </th>
                </tr>

                <tr>
                    <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="5">Não foi encontrado nenhuma reclamação de clientes!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $cliente['idSuporte'] ?></td>
                            <td><?php echo $cliente['nome'] ?></td>
                            <td><?php echo $cliente['titulo'] ?></td>
                            <td><?php echo $cliente['descSuporte'] ?></td>
                            <td><?php echo $cliente['tipoSuporte'] ?></td>
                            <td><?php echo $cliente['idUsuario'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="idUsuario" value="<?php echo $cliente['idUsuario'] ?>">
                                    <input type="hidden" name="descSuporte" value="<?php echo $cliente['descSuporte'] ?>">
                                    <input type="hidden" name="idSuporte" value="<?php echo $cliente['idSuporte'] ?>">
                                    <input type="submit" id="resolvido" name="resolvido" value="Resolvido!">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tr>

            </table>
        </div>
    </div>

    <br><br><br><br>

    <div>
        <form method="post">
            <div class="pesquisa">
                <label for="pesq">Buscar Nome da Confeitaria:</label>
                <div class="input-wrapper">
                    <input id="pesq" type="text" name="pesq" placeholder="Pesquise aqui:" required>
                    <button type="submit" id="pesq_confeitaria" name="pesq_confeitaria">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <br><br>

    <div>
        <h1>Reclamações de Confeitarias </h1>
        <div class="tabela-scroll">
            <table id="minhaTabela">
                <tr>
                    <th>
                        <center>ID</center>
                    </th>
                    <th>
                        <center>Nome da Confeitaria</center>
                    </th>
                    <th>
                        <center>Titulo</center>
                    </th>
                    <th>
                        <center>Descrição</center>
                    </th>
                    <th>
                        <center>Tipo de Suporte</center>
                    </th>
                    <th>
                        <center>ID do Usuario</center>
                    </th>
                    <th>
                        <center>Resolução</center>
                    </th>
                </tr>

                <tr>
                    <?php if (empty($confeitarias)): ?>
                    <tr>
                        <td colspan="5">Não foi encontrado nenhuma reclamação de confeitarias!</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($confeitarias as $confeitaria): ?>
                        <tr>
                            <td><?php echo $confeitaria['idSuporte'] ?></td>
                            <td><?php echo $confeitaria['nome'] ?></td>
                            <td><?php echo $confeitaria['titulo'] ?></td>
                            <td><?php echo $confeitaria['descSuporte'] ?></td>
                            <td><?php echo $confeitaria['tipoSuporte'] ?></td>
                            <td><?php echo $confeitaria['idUsuario'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="idUsuario" value="<?php echo $confeitaria['idUsuario'] ?>">
                                    <input type="hidden" name="descSuporte" value="<?php echo $confeitaria['descSuporte'] ?>">
                                    <input type="hidden" name="idSuporte" value="<?php echo $confeitaria['idSuporte'] ?>">
                                    <input type="submit" id="resolvido" name="resolvido" value="Resolvido!">
                                </form>
                            </td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tr>

            </table>
        </div>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>
</body>

</html>