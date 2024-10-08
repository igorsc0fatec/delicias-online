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
    <link rel="stylesheet" href="assets/css/style-card.css">

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

    <div class="ag-format-container">
        <div class="ag-courses_box">

            <div class="ag-courses_item">
                <a href="cadastrar-cobertura.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Coberturas
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="cadastrar-decoracao.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Decorações
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="cadastrar-formato.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Formatos
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="cadastrar-massa.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Massas
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="cadastrar-peso.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Pesos
                    </div>
                </a>
            </div>

            <div class="ag-courses_item">
                <a href="cadastrar-recheio.php" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title">
                        Recheios
                    </div>
                </a>
            </div>

        </div>
    </div>


    <br><br><br><br>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

</body>

</html>