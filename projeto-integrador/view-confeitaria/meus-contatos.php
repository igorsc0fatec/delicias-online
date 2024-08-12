<?php
session_start();
if (!isset($_SESSION['idConfeitaria'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-confeitaria.php'</script>";
}

include_once '../controller/controller-chat.php';
$controllerChat = new ControllerChat();

$idConfeitariaUsuario = $_SESSION['idUsuario']; // Assume que o idUsuario da confeitaria está na sessão
$conversasAtivas = $controllerChat->buscaConversa($idConfeitariaUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Meus Contatos - Delicia Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            flex: 0 0 auto;
        }

        .contacts-container {
            padding: 20px;
        }

        .contact {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .contact img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .contact a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
        }

        .contact a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="container">
            <header>
                <nav>
                    <div class="nav-container">
                        <a href="dashboard-confeitaria.php">
                            <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                        </a>
                        <i class="fas fa-bars btn-menumobile"></i>
                        <ul>
                            <li><a href="dashboard-confeitaria.php">Inicio</a></li>
                            <li><a href="meus-produtos.php">Meus Produtos</a></li>
                            <li><a href="meus-contatos.php">Chats</a></li>
                            <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                            <li><a href="editar-confeitaria.php">Meus Dados</a></li>
                        </ul>
                    </div>
                </nav>
            </header>
        </div>
    </div>

    <div>
        <br><br><br><br>
    </div>

    <div class="contacts-container">
        <h1>Meus Contatos</h1>
        <?php if (!empty($conversasAtivas)) { ?>
            <?php foreach ($conversasAtivas as $conversa) { ?>
                <div class="contact">
                    <img src="assets/img/user.png" alt="Foto de Perfil">
                    <a href="chat-confeitaria.php?u=<?php echo $conversa['idUsuario']; ?>">
                        <?php echo htmlspecialchars($conversa['nomeCliente']); ?>
                    </a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>Você não tem contatos ativos.</p>
        <?php } ?>
    </div>
</body>

</html>