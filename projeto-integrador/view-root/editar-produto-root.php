<?php
session_start();
if (!isset($_SESSION['idConfeitaria'])) {
    echo "<script language='javascript' type='text/javascript'> window.location.href='../view-root/confeitarias-root.php'</script>";
}

include_once '../controller/controller-produto.php';
$produtoController = new ControllerProduto();
$tipoProdutos = $produtoController->viewTipoProduto();
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome do Produto</label>
                        <input id="nomeProduto" type="text" name="nomeProduto" placeholder="Digite o Nome do Produto"
                            value="<?php echo $_GET['nome'] ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="price">Valor do Produto:</label>
                        <input id="valorProduto" type="number" min=0.01 step="0.01" name="valorProduto"
                            placeholder="Digite a nova Valor do Produto:" value="<?php echo $_GET['valor'] ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="frete">Frete:</label>
                        <input id="frete" type="number" min=0.01 step="0.01" maxlength="8" name="frete"
                            placeholder="Frete:" value="<?php echo $_GET['frete'] ?>" required>
                    </div>

                    <div class="input-box">
                        <label for="frete">Status do Produto:</label>
                        <select id="ativo" name="ativo">
                            <option value=1>Ativar</option>
                            <option value=0>Desativar</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="tipo">Tipo do Produto:</label>
                        <select id="tiposProduto" name="tiposProduto">
                            <?php foreach ($tipoProdutos as $tipo): ?>
                                <option value="<?php echo $tipo['idTipoProduto'] ?>"><?php echo $tipo['tipoProduto'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="img" class="upload-button">Escolha uma imagem</label>
                        <input id="img" type="file" accept="image/*" name="img" required onchange="previewImage()">
                        <p>*A imagem deve conter no máximo 16mb</p>
                        <span id="erroImagem" class="error"></span>
                    </div>

                    <div class="input-box">
                        <label for="descProduto">Descrição do Produto:</label>
                        <textarea id="descProduto" name="descProduto" placeholder="Descreva sobre o produto:"
                            maxlength="150" oninput="updateCharCount()" required><?php echo $_GET['desc'] ?></textarea>
                        <div id="charCount">150 caracteres restantes</div>
                    </div>
                </div>
                <input id="id" type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                <div class="continue-button">
                    <button type="submit" id="submit" name="submit">Editar</button>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                if ($produtoController->verificaEditProduto()) {
                    if ($produtoController->updateProduto()) {
                        echo "
                        <script>
                            Swal.fire({
                            title: 'Produto editado com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            didClose: () => {
                                window.location.href = 'produtos-root.php';
                                }
                            });
                        </script>";
                    }
                } else if ($produtoController->verificaProduto()) {
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
                    if ($produtoController->updateProduto()) {
                        echo "
                        <script>
                            Swal.fire({
                            title: 'Produto editado com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            didClose: () => {
                                window.location.href = 'produtos-root.php';
                                }
                            });
                        </script>";
                    }
                }
            }
            ?>

            <script src="assets/js/valida-produto-root.js"></script>
        </div>
    </div>

    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

</body>

</html>