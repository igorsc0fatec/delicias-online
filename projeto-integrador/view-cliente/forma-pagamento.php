<?php
session_start();
if (!isset($_SESSION['idCliente'])) {
    session_destroy();
    echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
} else if (isset($_SESSION['idTipoUsuario'])) {
    if ($_SESSION['idTipoUsuario'] != 2) {
        echo "<script language='javascript' type='text/javascript'> window.location.href='login-cliente.php'</script>";
    }
}

include_once '../controller/controller-pedido.php';
include_once '../controller/controller-cliente.php';
$controllerPedido = new ControllerPedido();
$controllerCliente = new ControllerCliente();
$formasPagamento = $controllerPedido->formaPagamento();
$enderecos = $controllerCliente->viewEndereco();

$formasPermitidas = ['Cartão de Crédito', 'Cartão de Débito', 'PIX', 'Boleto Bancário', 'Transferência Bancária'];

var_dump($_SESSION['carrinho']);
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
    <link rel="stylesheet" href="assets/css/style-pagamento.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolher Forma de Pagamento</title>
</head>

<body>
    <div class="container" style="margin-bottom: 50px;">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-cliente.php">
                        <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="meus-pedidos.php">Meus Pedidos</a></li>
                        <li><a href="editar-cliente.php">Meus Dados</a></li>
                        <li><a href="dashboard-cliente.php">Home</a></li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <div class="form-container">
        <div class="form-header">
            <h1>Escolher Forma de Pagamento</h1>
        </div>
        <form action="" method="post">
            <div class="payment-options">
                <?php foreach ($formasPagamento as $forma): ?>
                    <?php if (in_array($forma['formaPagamento'], $formasPermitidas)): ?>
                        <div class="payment-option">
                            <input type="radio" id="forma<?php echo $forma['idFormaPagamento']; ?>" name="formaPagamento"
                                value="<?php echo $forma['idFormaPagamento']; ?>" required
                                data-idformapagamento="<?php echo $forma['idFormaPagamento']; ?>">
                            <label for="forma<?php echo $forma['idFormaPagamento']; ?>"><i class="fas fa-credit-card"></i>
                                <?php echo $forma['formaPagamento']; ?></label>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="idFormaPagamento" id="idFormaPagamento">
            <div id="payment-details">
                <div id="cartãoDeCrédito" class="payment-details">
                    <h2>Detalhes do Cartão de Crédito</h2>
                    <label for="nomeCartao">Nome no Cartão:</label>
                    <input type="text" id="nomeCartao" name="nomeCartao">
                    <label for="numeroCartao">Número do Cartão:</label>
                    <input type="text" id="numeroCartao" name="numeroCartao">
                    <label for="validadeCartao">Validade:</label>
                    <input type="text" id="validadeCartao" name="validadeCartao">
                    <label for="cvvCartao">CVV:</label>
                    <input type="text" id="cvvCartao" name="cvvCartao">
                </div>
                <div id="cartãoDeDébito" class="payment-details">
                    <h2>Detalhes do Cartão de Débito</h2>
                    <label for="nomeCartaoDebito">Nome no Cartão:</label>
                    <input type="text" id="nomeCartaoDebito" name="nomeCartaoDebito">
                    <label for="numeroCartaoDebito">Número do Cartão:</label>
                    <input type="text" id="numeroCartaoDebito" name="numeroCartaoDebito">
                    <label for="validadeCartaoDebito">Validade:</label>
                    <input type="text" id="validadeCartaoDebito" name="validadeCartaoDebito">
                    <label for="cvvCartaoDebito">CVV:</label>
                    <input type="text" id="cvvCartaoDebito" name="cvvCartaoDebito">
                </div>
                <div id="pix" class="payment-details">
                    <h2>Chave PIX</h2>
                    <label for="chavePix">Chave PIX:</label>
                    <input type="text" id="chavePix" name="chavePix">
                </div>
                <div id="boletoBancário" class="payment-details">
                    <h2>Instruções para Boleto Bancário</h2>
                    <p>O boleto será gerado e enviado para o seu e-mail.</p>
                </div>
                <div id="transferênciaBancária" class="payment-details">
                    <h2>Detalhes para Transferência Bancária</h2>
                    <p>Banco: XXX</p>
                    <p>Agência: XXXX</p>
                    <p>Conta: XXXXXXX</p>
                </div>
            </div>
    </div>

    <div class="address-container" style="margin-top: 50px;">
        <div class="form-header">
            <h1>Escolher Endereço de Entrega</h1>
        </div>
        <div class="address-options">
            <?php foreach ($enderecos as $endereco) { ?>
                <div class="address-option">
                    <input type="radio" id="endereco" name="endereco" value=<?php echo $endereco['idEnderecoCliente']; ?>
                        required>
                    <label
                        for="endereco"><?php echo $endereco['logCliente'] . ', Nº ' . $endereco['numLocal'] . ', ' . $endereco['bairroCliente'] . ', ' . $endereco['cidadeCliente'] . ', ' . $endereco['ufCliente'] . ', ' . $endereco['cepCliente'] ?></label>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="submit-button" style="margin-top: 50px;">
        <button type="submit" name="confirmarPedido" id="confirmarPedido">Confirmar Pedido</button>
    </div>
    </form>

    <?php
    if (isset($_POST['confirmarPedido'])) {
        $idPedido = $controllerPedido->addPedido();
        if (!empty($idPedido)) {
            if ($controllerPedido->addItensPedido($idPedido)) {
                echo "
                <script>
                    Swal.fire({
                    title: 'Pedido feito com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    didClose: () => {
                                window.location.href = 'visualizar-pedido.php?i=$idPedido';
                                    }               
                    });
                </script>";
            }
        }
    }
    ?>

    <footer class="footer">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script>
        $(document).ready(function () {
            $('input[type=radio][name=formaPagamento]').change(function () {
                $('.payment-details').hide();
                let paymentType = $(this).val().toLowerCase().replace(/ /g, '');
                let idFormaPagamento = $(this).data('idformapagamento');

                $('#idFormaPagamento').val(idFormaPagamento);

                if (paymentType == 'cartãodecrédito') {
                    $('#cartãoDeCrédito').show();
                } else if (paymentType == 'cartãodedébito') {
                    $('#cartãoDeDébito').show();
                } else if (paymentType == 'pix') {
                    $('#pix').show();
                } else if (paymentType == 'boletobancário') {
                    $('#boletoBancário').show();
                } else if (paymentType == 'transferênciabancária') {
                    $('#transferênciaBancária').show();
                }
            });

            $('#confirmarPedido').click(function (event) {
                if (!$('input[name="formaPagamento"]:checked').val()) {
                    Swal.fire({
                        title: 'É necessário escolher uma forma de pagamento!',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    event.preventDefault();
                } else if (!$('input[name="endereco"]:checked').val()) {
                    Swal.fire({
                        title: 'É necessário escolher um endereço para a entrega!',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                    event.preventDefault();
                }
            });
        });

    </script>

</body>

</html>