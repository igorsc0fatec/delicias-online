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

include_once '../controller/controller-produto.php';
$produtoController = new ControllerProduto();

$tipoProdutos = $produtoController->viewTipoProduto();

if (isset($_GET['action']) && $_GET['action'] == 'fetch_data') {
    header('Content-Type: application/json');

    if (isset($_POST['pesq']) && !empty($_POST['pesq'])) {
        $produtos = $produtoController->pesquisaProduto();
    } else {
        $produtos = $produtoController->viewProduto();
    }

    echo json_encode($produtos);
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
    <title>Produtos</title>
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
                        <li><a href="cadastrar-personalizado.php">Personalizados</a></li>
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
            <img id="preview" src="assets/img/logo.png" alt="Imagem selecionada" style="max-width: 100%; height: auto;">
        </div>
        <div class="form">
            <form enctype="multipart/form-data" method="post" onsubmit="return validaProduto()">
                <div class="form-header">
                    <div class="title">
                        <h1>Produtos</h1>
                    </div>
                </div>
                <div class="input-box">
                    <div class="input-box">
                        <label for="nome">Nome do Produto*</label>
                        <input id="nomeProduto" type="text" name="nomeProduto" maxlength="100"
                            placeholder="Nome do Produto:" required>
                    </div>

                    <div class="input-box">
                        <label for="price">Valor do Produto*</label>
                        <input id="valorProduto" type="number" min=0.01 step="0.01" maxlength="8" name="valorProduto"
                            placeholder="Valor do Produto:" required>
                    </div>

                    <div class="input-box">
                        <label for="frete">Frete*</label>
                        <input id="frete" type="number" min=0.01 step="0.01" maxlength="8" name="frete"
                            placeholder="Frete:" required>
                    </div>

                    <div class="input-box">
                        <label for="tipo">Tipo do Produto</label>
                        <select id="tiposProduto" name="tiposProduto">
                            <?php foreach ($tipoProdutos as $tipo): ?>
                                <option value="<?php echo $tipo['idTipoProduto']; ?>"><?php echo $tipo['tipoProduto'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="img" class="upload-button">Escolha uma imagem*</label>
                        <input id="img" type="file" accept="image/*" name="img" required onchange="previewImage()">
                        <p>*A imagem deve conter no máximo 16mb</p>
                        <span id="erroImagem" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="descProduto">Descrição do Produto*</label>
                        <textarea id="descProduto" name="descProduto" placeholder="Descreva sobre o produto:"
                            maxlength="150" oninput="updateCharCount()" required></textarea>
                        <div id="charCount">150 caracteres restantes</div>
                    </div>

                </div>
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Cadastrar</button>
                </div>
            </form>
            <script src="assets/js/valida-produto.js"></script>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        if ($produtoController->verificaProduto()) {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao cadastrar o produto!',
                    text: 'Produto já cadastrado na plataforma!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
                </script>";
        } else {
            if ($produtoController->addProduto()) {
                echo "
                <script>
                    Swal.fire({
                    title: 'Produto cadastrado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                    });
                </script>";
            }
        }
    }
    $produtos = $produtoController->viewProduto();
    ?>

    <div>
        <br><br>
    </div>

    <div>
        <h2>Seus Produtos</h2>

        <form id="search-form" method="post">
            <div class="pesquisa">
                <label for="pesq">Buscar Produto</label>
                <div class="input-wrapper">
                    <input id="pesq" type="text" name="pesq"
                        placeholder="Digite o nome do produto/ex: Bolo de chocolate" required>
                    <button type="submit" name="pesquisa">Pesquisar</button>
                </div>
            </div>
        </form>
        <br>

        <div class="tabela-scroll">
            <table id="minhaTabela">
                <thead>
                    <tr>
                        <th>
                            <center>Imagem</center>
                        </th>
                        <th>
                            <center>Nome</center>
                        </th>
                        <th>
                            <center>Descrição</center>
                        </th>
                        <th>
                            <center>Tipo</center>
                        </th>
                        <th>
                            <center>Valor</center>
                        </th>
                        <th>
                            <center>Status</center>
                        </th>
                        <th>
                            <center>Frete</center>
                        </th>
                        <th>
                            <center>Editar</center>
                        </th>
                    </tr>

                </thead>
                <tbody id="produtos">
                </tbody>
            </table>
        </div>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script>
        $(document).ready(function () {
            function loadData(query = '') {
                $.ajax({
                    url: 'cadastrar-produto.php?action=fetch_data',
                    type: 'POST',
                    data: { pesq: query },
                    dataType: 'json',
                    success: function (data) {
                        var tableBody = $('#produtos');
                        tableBody.empty();
                        if (data.length === 0) {
                            tableBody.append('<tr><td colspan="8">Você não tem nenhum produto no momento</td></tr>');
                        } else {
                            data.forEach(function (produto) {
                                var row = $('<tr></tr>');
                                row.append('<td><img src="' + produto.imgProduto + '" alt="' + produto.nomeProduto + '" width="50"></td>');
                                row.append('<td>' + produto.nomeProduto + '</td>');
                                row.append('<td>' + produto.descProduto + '</td>');
                                row.append('<td>' + produto.tipoProduto + '</td>');
                                row.append('<td>' + produto.valorProduto + '</td>');
                                if (produto.ativoProduto == 1) {
                                    row.append('<td>' + 'Ativado' + '</td>');
                                } else {
                                    row.append('<td>' + 'Desativado' + '</td>');
                                }
                                row.append('<td>' + produto.frete + '</td>');
                                row.append('<td><button onclick="confirmarEdicao(' + produto.idProduto + ',\'' + produto.nomeProduto + '\', \'' + produto.descProduto + '\', \'' + produto.valorProduto + '\', \'' + produto.frete + '\')">Editar</button></td>');
                                tableBody.append(row);
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            $('#search-form').on('submit', function (e) {
                e.preventDefault();
                var query = $('#pesq').val();
                loadData(query);
            });

            loadData();
        });

        function confirmarEdicao(idProduto, nomeProduto, descProduto, valorProduto, frete) {
            Swal.fire({
                title: 'Tem certeza que deseja editar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, editar!',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = `editar-produto.php?id=${idProduto}&nome=${nomeProduto}&desc=${descProduto}&valor=${valorProduto}&frete=${frete}`;
                    window.location.href = url;
                }
            });
        }
    </script>
</body>

</html>