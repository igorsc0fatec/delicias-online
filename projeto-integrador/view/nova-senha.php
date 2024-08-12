<?php
include_once '../controller/controller-usuario.php';
$usuarioController = new ControllerUsuario();

$email = $_GET['emailUsuario'];

if (isset($_POST['submit'])) {
    if ($usuarioController->addNovaSenha()) {
        echo '<script>alert("senha alterada com sucesso!")</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style2.css">
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
                        <h1>Insira a nova senha!</h1>
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

                <input type="hidden" name="emailUsuario" value="<?php echo $email; ?>">
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Cadastrar nova senha</button>
                </div>
            </form>
            <script src="assets/js/valida-senha.js"></script>
        </div>
    </div>

</body>

</html>