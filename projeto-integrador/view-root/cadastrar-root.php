<?php
include_once '../controller/controller-usuario.php';
$usuario = new ControllerUsuario();

session_start();
if (!isset($_SESSION['emailUsuario'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='../view/index.php'</script>";
}

if (isset($_POST['submit'])) {
    $usuario->addUsuario();
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
                        <li><a href="Clientes-root.php">Clientes</a></li>
                        <li><a href="Confeitarias-root.php">Confeitarias</a></li>
                        <li><a href="cadastrar-root.php">Novo Adm</a></li>
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
            <form action="#" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastrar ADM</h1>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="emailUsuario" type="email" name="emailUsuario" placeholder="Digite seu E-mail"
                            required>
                        <label for="Senha">Senha</label>
                        <input id="senhaUsuario" type="password" name="senhaUsuario" placeholder="Digite sua senha"
                            minlength="8" maxlength="15" required>
                        <label for="confirmPassword">Confirme sua Senha</label>
                        <input id="confirmaSenha" type="password" name="confirmaSenha"
                            placeholder="Digite sua senha novamente" minlength="8" maxlength="15" required>
                        <span id="erroSenha1" class="error"></span>
                        <input id="msg" type="hidden" name="msg" value=1>
                    </div>
                </div>
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    </div>

    <div>
        <br><br>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

</body>

</html>