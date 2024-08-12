<?php
session_start();
if (!isset($_SESSION['idCliente'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    exit();
} else if (isset($_SESSION['idTipoUsuario']) && $_SESSION['idTipoUsuario'] != 2) {
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    exit();
}

include_once '../controller/controller-usuario.php';
include_once '../controller/controller-chat.php';
$controller = new ControllerUsuario();
$controllerChat = new ControllerChat();

$idConfeitaria = $_GET['c'];
$dadosConfeitaria = $controller->getDadosConfeitaria($idConfeitaria);
$idUsuarioConf = $controllerChat->buscaConfeitaria($idConfeitaria);
$idCliente = $_SESSION['idUsuario'];

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'fetch_mensagens') {
        $idUsuarioConf = $controllerChat->buscaConfeitaria($idConfeitaria);
        $mensagens = $controllerChat->getMensagens($idCliente, $idUsuarioConf[0]['idUsuario']);
        header('Content-Type: application/json');
        echo json_encode($mensagens);
        exit();
    }

    if ($_GET['action'] == 'fetch_online_status') {
        $dadosConfeitaria = $controller->getDadosConfeitaria($idConfeitaria);
        $user_online = strtotime($dadosConfeitaria[0]["online"]);
        $status_online = $controllerChat->timing($user_online);
        header('Content-Type: application/json');
        echo json_encode(['status_online' => $status_online]);
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Adiciona uma mensagem usando o controllerChat
    $controllerChat->addMensagem();

    // Redireciona para evitar reenvio ao recarregar a página
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Chat com a Confeitaria - Delicia Online</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <link rel="stylesheet" href="assets/css/style-chat.css">

</head>

<body>
    <div class="header">
        <div class="container">
            <header>
                <nav>
                    <div class="nav-container">
                        <a href="dashboard-cliente.php">
                            <img id="logo" src="assets/img/logo.png" alt="Delicia Online">
                        </a>
                        <i class="fas fa-bars btn-menumobile"></i>
                        <ul>
                            <li><a href="dashboard-cliente.php">Adicionar Produtos</a></li>
                            <li><a href="dados-confeitaria.php?c=<?php echo $idConfeitaria ?>">Confeitaria</a></li>
                            <li><a href="editar-cliente.php">Meus Dados</a></li>
                            <li><a href="carrinho.php"><i class="fa fa-shopping-cart" style="font-size:25px"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        </div>
    </div>

    <div>
        <br><br><br><br>
    </div>

    <div class="chat-container">
        <div class="sidebar">
            <div class="profile-image">
                <img id="confeitaria-img" src="../view-confeitaria/<?php echo $dadosConfeitaria[0]['imgConfeitaria'] ?>"
                    alt="<?php echo $dadosConfeitaria[0]['nomeConfeitaria'] ?>">
            </div>
            <h2 id="confeitaria-nome"><?php echo htmlspecialchars($dadosConfeitaria[0]['nomeConfeitaria']); ?></h2>
            <p id="confeitaria-online-status"></p>
            <p>Membro desde: <?php echo date('d/m/Y', strtotime($dadosConfeitaria[0]['dataCriacao'])); ?></p>
        </div>

        <div class="chat-content">
            <div class="chat-header">
                Chat com <?php echo htmlspecialchars($dadosConfeitaria[0]['nomeConfeitaria']); ?>
            </div>
            <div id="chat-messages" class="chat-messages" style="overflow-y: scroll; height: 400px;">
            </div>
            <div class="chat-footer">
                <form method="POST" enctype="multipart/form-data" id="chat-form">
                    <input type="number" value="<?php echo $idUsuarioConf[0]['idUsuario']; ?>" name="id" hidden>
                    <input type="text" placeholder="Digite sua mensagem" name="mensagem" id="message-input" required>
                    <label for="upload-image" class="upload-image-btn">
                        <i class="fas fa-image"></i>
                    </label>
                    <input type="file" name="img" id="upload-image" accept="image/*" onchange="submitForm()">
                    <button type="submit" name="enviar" id="send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            function loadMensagens() {
                $.ajax({
                    url: 'chat-cliente.php?action=fetch_mensagens&c=<?php echo $idConfeitaria; ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        var chatMessages = $('#chat-messages');
                        chatMessages.empty();
                        data.forEach(function (mensagem) {
                            var messageClass = mensagem.idRemetente == <?php echo $idCliente; ?> ? 'sent' : 'received';
                            var messageContent = mensagem.imagem ? `<img src="${mensagem.imagem}" alt="imagem">` : `<p>${mensagem.mensagem}</p>`;
                            var mensagemHtml = `
                            <div class="chat-message ${messageClass}">
                                <div class="chat-message-content">
                                    ${messageContent}
                                    <span style="font-size: 0.8em; color: gray;">${new Date(mensagem.dataEnvio).toLocaleString()}</span>
                                </div>
                            </div>`;
                            chatMessages.append(mensagemHtml);
                        });
                        chatMessages.scrollTop(chatMessages[0].scrollHeight);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro ao carregar mensagens: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            function checkOnlineStatus() {
                $.ajax({
                    url: 'chat-cliente.php?action=fetch_online_status&c=<?php echo $idConfeitaria; ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#confeitaria-online-status').text('Última vez online: ' + data.status_online);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro ao verificar status online: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            function updateOnlineStatus() {
                $.ajax({
                    url: 'chat-cliente.php?action=update_online_status',
                    type: 'POST',
                    success: function () {
                        console.log('Status online atualizado');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Erro ao atualizar status online: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }

            loadMensagens();
            checkOnlineStatus();
            setInterval(loadMensagens, 5000);
            setInterval(checkOnlineStatus, 60000);
            setInterval(updateOnlineStatus, 3000);
        });

        function submitForm() {
            document.getElementById("chat-form").submit();
        }

        function scrollToBottom() {
            var chatMessages = $('#chat-messages');
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }

        $(document).ready(function () {
            loadMensagens();
            scrollToBottom();  // Adicionado aqui
            setInterval(loadMensagens, 5000);
            setInterval(checkOnlineStatus, 60000);
            setInterval(updateOnlineStatus, 3000);
        });
    </script>

</body>

</html>