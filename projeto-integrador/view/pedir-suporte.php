<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='index.php'</script>";
}

include_once '../controller/controller-usuario.php';
$usuario = new ControllerUsuario();
$tiposSuporte = $usuario->viewTipoSuporte();
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
    <title>Suporte</title>

</head>

<body>
    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="../view-cliente/dashboard-cliente.php">
                        <img id="logo" src="../view-cliente/assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="javascript:void(0)" onclick="voltar()">Voltar</a></li>
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
            <img src="assets/img/suporte.png" alt="">
        </div>

        <div class="form">
            <form method="post">

                <div class="form-header">
                    <div class="title">
                        <h1>Suporte</h1>
                    </div>
                </div>

                <div class="input-box">
                    <div class="input-box">
                        <label for="Suporte">Titulo do Suporte*</label>
                        <input id="titulo" type="text" name="titulo" placeholder="Digite o Titulo do Suporte" required>
                    </div>

                    <div class="input-box">
                        <label for="descSuporte">Descrição do Suporte*</label>
                        <textarea id="descSuporte" name="descSuporte" placeholder="Descreva sobre o ocorrido:"
                            maxlength="150" oninput="updateCharCount()" required></textarea>
                        <div id="charCount">150 caracteres restantes</div>
                    </div>

                    <div class="input-box">
                        <label>Tipo do Suporte</label>
                        <select id="tipoSuporte" name="tipoSuporte">
                            <?php foreach ($tiposSuporte as $tipo) { ?>
                                <option value="<?php echo $tipo['idTipoSuporte']; ?>">
                                    <?php echo $tipo['tipoSuporte'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="continue-button">
                    <button type="submit" id="suporte" name="suporte">Enviar Solicitação!</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['suporte'])) {
        if ($usuario->pedirSuporte()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Solicitação de suporte enviada com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    });
                </script>";
        }
    }
    ?>

    <div>
        <br><br>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script src="assets/js/valida-suporte.js"></script>

    <script>
        function voltar() {
            window.history.back();
        }
    </script>
</body>

</html>