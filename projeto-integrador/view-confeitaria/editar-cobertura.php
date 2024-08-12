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

include_once '../controller/controller-cobertura.php';
$coberturaController = new ControllerCobertura();
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
    <link rel="stylesheet" href="assets/css/style-form-table.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cobertura</title>
</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-confeitaria.php">
                        <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="cadastrar-produto.php">Produtos</a></li>
                        <li><a href="addProdPersonalizado.php">Personalizados</a></li>
                        <li><a href="regras-confeitaria.php">Regras</a></li>
                        <li><a href="meus-produtos.php">Voltar </a></li>
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
            <img src="assets/img/logo.png" alt="">
        </div>
        <div class="form">
            <form method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Coberturas</h1>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="descCobertura">Cobertura</label>
                        <textarea id="descricao" name="descricao" placeholder="Descreva a cobertura:" maxlength="150"
                            oninput="updateCharCount()" required><?php echo $_GET['desc'] ?></textarea>
                        <div id="charCount">150 caracteres restantes</div>
                    </div>
                </div>
                <input id="id" type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Editar</button>
                </div>
            </form>
            <script src="assets/js/valida-regras.js"></script>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        if ($coberturaController->verificaEditCobertura()) {
            if ($coberturaController->updateCobertura()) {
                echo "
                    <script>
                        Swal.fire({
                        title: 'Cobertura editada com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        didClose: () => {
                                window.location.href = 'cadastrar-cobertura.php';
                            }
                        });
                    </script>";
            }
        } else if ($coberturaController->verificaCobertura()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao editar cobertura!',
                    text: 'Essa cobertura já esta cadastrado!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else {
            if ($coberturaController->updateCobertura()) {
                echo "
                    <script>
                        Swal.fire({
                        title: 'Cobertura editada com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        didClose: () => {
                                window.location.href = 'cadastrar-cobertura.php';
                            }
                        });
                    </script>";
            }
        }
    }
    ?>

    <div>
        <br><br>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

</body>

</html>