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

include_once '../controller/controller-usuario.php';
$usuarioController = new ControllerUsuario();

$usuario = $usuarioController->viewUsuario();

if (isset($_GET['action']) && $_GET['action'] == 'fetch_data') {
    header('Content-Type: application/json');
    echo json_encode($usuario);
    exit;
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
    <link rel="stylesheet" href="../view-cliente/assets/css/style-menu.css">
    <link rel="stylesheet" href="../view-cliente/assets/css/style-form-table.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados de Usuario</title>

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
                        <li><a href="editar-cliente.php">Dados Pessoais</a></li>
                        <li><a href="cadastrar-telefone-cliente.php">Telefone</a></li>
                        <li><a href="editar-usuario-cliente.php">Senha</a></li>
                        <li><a href="cadastrar-endereco.php">Endereço</a></li>
                        <li><a href="#" onclick="confirmarDesativarConta()">Desativar Conta</a></li>
                        <li><a href="dashboard-cliente.php">Voltar </a></li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <div>
        <br><br><br><br><br><br>
    </div>

    <div class="form-container">
        <div class="form-image">
            <img src="assets/img/pessoa.webp" alt="">
        </div>
        <div class="form">
            <div class="container">
                <form id="form" method="post" onsubmit="return validaEditUsuario()">
                    <div class="form-header">
                        <div class="title">
                            <h1>Dados do usuario</h1>
                        </div>
                    </div>
                    <?php foreach ($usuario as $u): ?>
                        <div class="input-box">
                            <label for="email">Email*</label>
                            <input type="email" id="emailUsuario" name="emailUsuario"
                                 required>
                        </div>
                    <?php endforeach ?>
                    <div class="input-box">
                        <label for="senha">Senha*</label>
                        <input id="senhaUsuario" type="password" name="senhaUsuario" placeholder="Digite sua senha"
                            minlength="8" maxlength="15" required>
                    </div>
                    <div class="input-box">
                        <label for="confirmPassword">Confirmar Senha*</label>
                        <input id="confirmaSenha" type="password" name="confirmaSenha"
                            placeholder="Digite sua senha novamente" minlength="8" maxlength="15" required>
                        <span id="erroSenha1" class="error"></span>
                    </div>
                    <input type="hidden" id="msg" name="msg" value="cl">
                    <div class="continue-button">
                        <button type="submit" id="editar" name="editar">Editar</button>
                    </div>
                </form>
                <script src="assets/js/valida-usuario.js"></script>
                <script src="assets/js/valida-enviar.js"></script>
            </div>
        </div>

        <?php
        if (isset($_POST['editar'])) {
            if ($usuarioController->verificaEditEmail()) {
                $_SESSION['senhaUsuario'] = $_POST['senhaUsuario'];
                $usuarioController->enviaEmail();
            } else if ($usuarioController->verificaEmail()) {
                echo "
                    <script>
                        Swal.fire({
                        title: 'Erro ao cadastrar email!',
                        text: 'Esse email ja existe',
                        icon: 'error',
                        confirmButtonText: 'OK'
                                });
                    </script>";
            } else {
                $_SESSION['senhaUsuario'] = $_POST['senhaUsuario'];
                $_SESSION['emailUsuario'] = $_POST['emailUsuario'];
                $usuarioController->enviaEmail();
            }
        }

        if (isset($_GET['v'])) {
            if (isset($_SESSION['senhaUsuario']) && isset($_SESSION['emailUsuario'])) {
                $senhaUsuario = $_SESSION['senhaUsuario'];
                $emailUsuario = $_SESSION['emailUsuario'];
                if($usuarioController->updateUsuario($senhaUsuario, $emailUsuario)){
                    echo "
                    <script>
                        Swal.fire({
                            title: 'Dados alterados com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                }
            }
        }
        ?>

    </div>

    <div>
        <br><br>
    </div>
    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script>
        $(document).ready(function () {
            function loadData() {
                $.ajax({
                    url: 'editar-usuario-cliente.php?action=fetch_data',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        if (data.length > 0) {
                            var user = data[0];
                            $('#emailUsuario').val(user.emailUsuario);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            loadData();
        });
    </script>

</body>

</html>