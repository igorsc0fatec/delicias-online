<?php
include_once '../controller/controller-usuario.php';
include_once '../controller/controller-cliente.php';

$usuarioController = new ControllerUsuario();
$clienteController = new controllerCliente();
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
            <img src="assets/img/pessoa.webp" alt="">
        </div>
        <div class="form">
            <form id="form" method="post" onsubmit="return validaCliente()">
                <div class="form-header">
                    <div class="title">
                        <h1>Insira os seus Dados</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="login-cliente.php">Entrar</a></button>
                    </div>
                </div>

                <div class="input-group">

                    <div class="input-box">
                        <label for="nome">Nome Completo</label>
                        <input id="nomeCliente" type="text" name="nomeCliente" placeholder="Digite seu nome " required>
                    </div>

                    <div class="input-box">
                        <label for="email">E-mail</label>
                        <input id="emailUsuario" type="email" name="emailUsuario" placeholder="Digite seu E-mail"
                            required>
                    </div>

                    <div class="input-box">
                        <label for="date">Data de Nascimento</label>
                        <input id="nascCliente" type="date" name="nascCliente"
                            placeholder="Digite sua data de nascimento " required>
                        <span id="erroData" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="cpf">CPF</label>
                        <input id="cpfCliente" type="text" name="cpfCliente" placeholder="Digite seu CPF" required>
                        <span id="erroCpf" class="error"></span>
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
                        <input id="numLocal" type="text" name="numLocal" required>
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

                    <input type="hidden" id="msg" name="msg" value="2">
                </div>
                <div class="continue-button">
                    <button type="submit" id="cadastrar" name="cadastrar">Cadastrar</button>
                </div>
            </form>

            <?php
            if (isset($_POST['cadastrar'])) {
                if ($clienteController->verificaCPF()) {
                    echo "
                        <script>
                            Swal.fire({
                            title: 'Erro ao cadastrar usuario!',
                            text: 'Esse CPF já esta em uso!',
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
                        if ($clienteController->addCliente()) {
                            $usuarioController->enviaEmail();
                        }
                    }
                }
            }
            ?>
            <script src="assets/js/valida-cliente.js"></script>
        </div>
    </div>
</body>

</html>