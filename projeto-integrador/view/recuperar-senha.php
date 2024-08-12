<?php
include_once '../controller/controller-usuario.php';
$usuarioController = new ControllerUsuario();

if (isset($_POST['submit'])) {
    if ($usuarioController->verificaEmail()) {
        $usuarioController->enviaEmail();
    } else {
        echo '<script>alert("Email não encontrado!")</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style2.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="assets/img/cadeado.png" alt="">
        </div>
        <div class="form">
            <form action="" id="form" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Insira o seu email*</h1>
                    </div>
                </div>
                <div class="input-group">

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input type="email" id="emailUsuario" name="emailUsuario" placeholder="Digite aqui o seu email" required>
                    </div>
                    <input type="hidden" id="msg" name="msg" value="recuperarSenha">
                </div>
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Verificar</button>
                </div>

                <div class="continue-button">
                    <button onclick="goBack()">Voltar</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>