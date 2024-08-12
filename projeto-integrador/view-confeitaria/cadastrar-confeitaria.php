<?php
include_once '../controller/controller-usuario.php';
include_once '../controller/controller-confeitaria.php';

$usuarioController = new ControllerUsuario();
$confeitariaController = new controllerConfeitaria();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style-form.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Formulário</title>
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img id="preview" src="assets/img/empresa 2.png" alt="Imagem selecionada"
                style="max-width: 100%; height: auto;">
        </div>
        <div class="form">
            <form id="form" method="post" enctype="multipart/form-data" onsubmit="return validaConfeitaria()">
                <div class="form-header">
                    <div class="title">
                        <h1>Insira os dados da sua confeitaria</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="login-confeitaria.php">Entrar</a></button>
                    </div>
                </div>

                <div class="input-group">

                    <div class="input-box">
                        <label for="nomeFantasia">Nome da Confeitaria</label>
                        <input id="nomeConfeitaria" type="text" name="nomeConfeitaria"
                            placeholder="Digite seu nome Fantasia" required>
                    </div>

                    <div class="input-box">
                        <label for="email">Email</label>
                        <input id="emailUsuario" type="email" name="emailUsuario" placeholder="Digite seu E-mail"
                            required>
                    </div>

                    <div class="input-box">
                        <label for="CNPJ">CNPJ</label>
                        <input id="cnpjConfeitaria" type="text" name="cnpjConfeitaria" placeholder="Digite seu CNPJ"
                            required>
                        <span id="erroCnpj" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="CEP">CEP</label>
                        <input type="text" id="cep" name="cep" placeholder="Digite seu cep" required>
                        <span id="erroCep1" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="Logradouro">Logradouro</label>
                        <input id="logradouro" type="text" name="logradouro" readonly>
                    </div>

                    <div class="input-box">
                        <label for="nunlocal">Nº do Local</label>
                        <input id="numLocal" type="text" name="numLocal" placeholder="Digite o Nº" required>
                    </div>

                    <div class="input-box">
                        <label for="bairro">Bairro</label>
                        <input id="bairro" type="text" name="bairro" readonly>
                    </div>

                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input id="cidade" type="text" name="cidade" readonly>
                    </div>

                    <div class="input-box">
                        <label for="uf">UF</label>
                        <input id="uf" type="text" name="uf" readonly>
                    </div>

                    <div class="input-box">
                        <label for="password">Senha</label>
                        <input id="senhaUsuario" type="password" name="senhaUsuario" placeholder="Digite sua senha"
                            minlength="8" maxlength="15" required>
                    </div>

                    <div class="input-box">
                        <label for="confirmPassword">Confirme sua Senha</label>
                        <input id="confirmaSenha" type="password" name="confirmaSenha"
                            placeholder="Digite sua senha novamente" minlength="8" maxlength="15" required>
                        <span id="erroSenha1" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="img" class="upload-button">Escolha uma imagem</label>
                        <input id="img" type="file" accept="image/*" name="img" required onchange="previewImage()">
                        <p>*A imagem deve conter no máximo 16mb</p>
                        <span id="erroImagem" class="error"></span>
                    </div>
                </div>

                <input type="hidden" id="msg" name="msg" value="3">
                <div class="continue-button">
                    <button type="submit" id="cadastrar" name="cadastrar">Cadastrar</button>
                </div>
            </form>
            <script src="assets/js/valida-confeitaria.js"></script>
        </div>
    </div>

    <?php
    if (isset($_POST['cadastrar'])) {
        if ($confeitariaController->verificaCNPJ()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao cadastrar usuario!',
                    text: 'Esse CNPJ já esta em uso!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else if ($usuarioController->verificaEmail()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao cadastrar usuario!',
                    text: 'Esse Email já esta em uso!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else {
            if ($usuarioController->addUsuario()) {
                if ($confeitariaController->addConfeitaria()) {
                    $usuarioController->enviaEmail();
                }
            }
        }
    }
    ?>
</body>

</html>