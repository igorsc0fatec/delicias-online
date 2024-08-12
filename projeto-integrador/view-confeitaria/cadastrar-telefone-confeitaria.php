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

include_once '../controller/controller-confeitaria.php';
$confeitariaController = new ControllerConfeitaria();
$telefones = $confeitariaController->viewTelefone();
$tipoTelefone = $confeitariaController->viewTipoTelefone();

if (isset($_GET['action']) && $_GET['action'] == 'fetch_data') {
    header('Content-Type: application/json');
    echo json_encode($telefones);
    exit;
}

if (isset($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode($confeitariaController->deleteTelefone($_GET['id']));
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
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <link rel="stylesheet" href="assets/css/style-form-table.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <title>Telefones</title>

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
                        <li><a href="editar-confeitaria.php">Dados da Confeitaria</a></li>
                        <li><a href="cadastrar-telefone-confeitaria.php">Telefone</a></li>
                        <li><a href="editar-usuario-confeitaria.php">Senha</a></li>
                        <li><a href="#" onclick="confirmarDesativarConta()">Desativar Conta</a></li>
                        <li><a href="dashboard-confeitaria.php">Voltar </a></li>
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
            <form id="form" method="post" onsubmit="return validaTelefone()">
                <div class="form-header">
                    <div class="title">
                        <h1>Telefone</h1>
                    </div>
                </div>
                <div class="input-box">
                    <div class="input-box">
                        <label for="telefone">Telefone*</label>
                        <input id="telefone" type="text" name="telefone" placeholder="Digite seu telefone" required>
                    </div>

                    <div class="input-box">
                        <label for="telefone">Tipo do Telefone*</label>
                        <select id="tipoTelefone" name="tipoTelefone">
                            <?php foreach ($tipoTelefone as $tipo) { ?>
                                <option value="<?php echo $tipo['idTipoTelefone']; ?>">
                                    <?php echo $tipo['tipoTelefone'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        if ($confeitariaController->verificaTelefone()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao cadastrar telefone!',
                    text: 'Esse telefone ja existe',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                </script>";
        } else if (!$confeitariaController->verificaDDD()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao cadastrar telefone!',
                    text: 'Esse DDD não existe',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else if ($confeitariaController->countTelefone()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Maximo de Telefones atingido!',
                    text: 'Você pode cadastrar no maximo 3 Telefones',
                    icon: 'info',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else {
            if ($confeitariaController->addTelefone()) {
                echo "
                <script>
                    Swal.fire({
                        title: 'Cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        }
    }
    ?>

    <div>
        <br><br>
    </div>

    <div>
        <h2>Seus Telefones</h2>
        <table id="minhaTabela">
            <thead>
                <tr>
                    <th>Telefone</th>
                    <th>Tipo</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody id="telefones">

            </tbody>
        </table>

        <script src="assets/js/valida-telefone.js"></script>
        <script src="assets/js/valida-enviar.js"></script>

        <script>
            $(document).ready(function () {
                function loadData() {
                    $.ajax({
                        url: 'cadastrar-telefone-confeitaria.php?action=fetch_data',
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            var tableBody = $('#telefones');
                            if (data.length === 0) {
                                tableBody.append('<tr><td colspan="3">Você não tem nenhum telefone no momento</td></tr>');
                            } else {
                                data.forEach(function (telefone) {
                                    var row = $('<tr></tr>');
                                    row.append('<td>' + telefone.numTelConfeitaria + '</td>');
                                    row.append('<td>' + telefone.tipoTelefone + '</td>');
                                    row.append('<td><button onclick="confirmarExclusao(' + telefone.idTelConfeitaria + ')">Excluir</button></td>');
                                    tableBody.append(row);
                                });
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Erro: ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                }

                loadData();
            });

            function confirmarExclusao(idTelConfeitaria) {
                Swal.fire({
                    title: 'Tem certeza que deseja excluir?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Não, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'cadastrar-telefone-confeitaria.php?id=' + idTelConfeitaria,
                            type: 'POST',
                            data: { idTelConfeitaria: idTelConfeitaria },
                            success: function (response) {
                                Swal.fire(
                                    'Excluído!',
                                    'O telefone foi excluído.',
                                    'success',
                                ).then(() => {
                                    window.location.href = 'cadastrar-telefone-confeitaria.php';
                                });
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                Swal.fire(
                                    'Erro!',
                                    'Ocorreu um erro ao excluir o telefone.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
        </script>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

</body>

</html>