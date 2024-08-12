<?php
session_start();
if (!isset($_SESSION['idUsuario'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='index.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style2.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Recuperar Senha</title>
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="assets/img/cadeado.png" alt="">
        </div>
        <div class="form">

            <form action="" id="form" method="post" onsubmit="return validaSenha()">
                <div class="form-header">
                    <div class="title">
                        <h1>Insira a sua senha pra confirmar a desativação da conta!</h1>
                    </div>
                </div>
                <div class="input-box">
                    <label for="senhaUsuario">Senha*</label>
                    <input type="password" id="senhaUsuario" name="senhaUsuario" minlength="8" maxlength="15" required>
                </div>

                <div class="input-box">
                    <label for="confirmaSenha">Confirmar Senha*</label>
                    <input type="password" id="confirmaSenha" name="confirmaSenha" minlength="8" maxlength="15"
                        required>
                    <span id="erroSenha1" class="error"></span>
                </div>

                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Desativar Conta!</button>
                </div>
                <div class="continue-button">
                    <button type="button" onclick="voltar()">Voltar</button>
                </div>
            </form>

            <?php
            include_once '../controller/controller-usuario.php';
            $usuarioController = new ControllerUsuario();

            if (isset($_POST['submit'])) {
                if ($usuarioController->desativaUsuario()) {
                    echo "
                <script>
                    Swal.fire({
                    title: 'Conta desativada com sucesso!',
                    text: 'Para reativa-la faça login novamente!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    didClose: () => {
                window.location.href = 'index.php';
            }
                    });
                </script>";
                    session_destroy();
                } else {
                    echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao desativar a conta!',
                    text: 'A senha esta incorreta!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
                }
            }
            ?>
            <script src="assets/js/valida-senha.js"></script>
            <script src="assets/js/valida-enviar.js"></script>
        </div>
    </div>
</body>

</html>