<?php
session_start();
include_once '../controller/controller-pedido.php';

if (isset($_POST['remover'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['carrinho'][$index])) {
        unset($_SESSION['carrinho'][$index]);
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
}

if (isset($_POST['atualizar'])) {
    $index = $_POST['index'];
    $novaQuantidade = $_POST['quantidade'];
    if (isset($_SESSION['carrinho'][$index])) {
        $_SESSION['carrinho'][$index]['quantidade'] = $novaQuantidade;
    }
}


$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$total = 0;
$quantidadeTotal = 0;
$frete = 0;
foreach ($carrinho as $produto) {
    $total += $produto['valorProduto'] * $produto['quantidade'];
    $quantidadeTotal += $produto['quantidade'];
    $frete = $produto['frete'];
    $total = $total + $produto['frete'];
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-menu.css">
    <link rel="stylesheet" href="assets/css/style-carrinho.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container">
        <header>
            <nav>
                <div class="nav-container">
                    <a href="dashboard-cliente.php">
                        <img id="logo" src="assets/img/logo.png" alt="JobFinder">
                    </a>
                    <i class="fas fa-bars btn-menumobile"></i>
                    <ul>
                        <li><a href="meus-pedidos.php">Meus Pedidos</a></li>
                        <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                        <li><a href="editar-cliente.php">Meus Dados</a></li>
                        <li><a href="carrinho.php"><i class="fa fa-shopping-cart" style="font-size:25px"></i></a></li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <br><br><br>

    <div class="container px-3 my-5 clearfix">
        <div class="card">
            <div class="card-header">
                <h2>Carrinho de Compras</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Nome e Detalhes do Produto
                                </th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Preço</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">Quantidade</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Frete</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Excluir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($carrinho)) { ?>
                                <tr>
                                    <td colspan="5" class="text-center">Seu carrinho está vazio.</td>
                                </tr>
                            <?php } else { ?>
                                <?php foreach ($carrinho as $index => $produto) { ?>
                                    <tr>
                                        <td class="p-4">
                                            <div class="media align-items-center">
                                                <img src="../view-confeitaria/<?php echo $produto['imgProduto']; ?>"
                                                    class="d-block ui-w-40 ui-bordered mr-4"
                                                    alt="<?php echo $produto['nomeProduto']; ?>">
                                                <div class="media-body">
                                                    <a href="#"
                                                        class="d-block text-dark"><?php echo $produto['nomeProduto']; ?></a>
                                                    <small>
                                                        <span class="text-muted">Descrição:
                                                        </span><?php echo $produto['descProduto']; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">R$
                                            <?php echo number_format($produto['valorProduto'], 2, ',', '.'); ?>
                                        </td>
                                        <td class="align-middle p-4">
                                            <form action="" method="post" style="display: flex; align-items: center;">
                                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                                <input type="number" name="quantidade"
                                                    value="<?php echo $produto['quantidade']; ?>"
                                                    class="form-control form-control-quantity text-center" min="1" max="5">
                                                <button type="submit" name="atualizar"
                                                    class="btn btn-sm btn-outline-primary ml-2">Atualizar</button>
                                            </form>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">R$
                                            <?php echo number_format($produto['frete'], 2, ',', '.'); ?>
                                        </td>
                                        <td class="text-right font-weight-semibold align-middle p-4">R$
                                            <?php echo number_format($produto['valorProduto'] * $produto['quantidade'], 2, ',', '.'); ?>
                                        </td>
                                        <td class="text-center align-middle px-0">
                                            <form action="" method="post" class="remove-form">
                                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                                <button type="submit" name="remover"
                                                    class="close text-danger remove-button">&times;</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4">
                        <label class="text-muted font-weight-normal">Código Promocional</label>
                        <input type="text" placeholder="ABC" class="form-control">
                    </div>
                    <div class="d-flex">
                        <div class="text-right mt-4 mr-5">
                            <label class="text-muted font-weight-normal m-0">Desconto</label>
                            <div class="text-large"><strong>R$ 0,00</strong></div>
                        </div>
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Preço Total</label>
                            <div class="text-large"><strong>R$
                                    <?php echo number_format($total, 2, ',', '.'); ?></strong></div>
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <?php if (empty($carrinho)) { ?>
                        <a href="dashboard-cliente.php"
                            class="btn btn-lg btn-default md-btn-flat mt-2 mr-3 btn-link-style">Voltar às compras</a>
                    <?php } else { ?>
                        <a href="dados-confeitaria.php?c=<?php echo $produto['idConfeitaria']; ?>"
                            class="btn btn-lg btn-default md-btn-flat mt-2 mr-3 btn-link-style">Voltar às compras</a>
                    <?php } ?>
                    <form action="" method="post" style="display: inline;">
                        <input type="hidden" name="quantidadeTotal" value="<?php echo $quantidadeTotal; ?>">
                        <input type="hidden" name="valorTotal"
                            value="<?php echo number_format($total, 2, ',', '.'); ?>">
                        <input type="hidden" name="frete" value="<?php echo number_format($frete, 2, ',', '.'); ?>">
                        <button type="submit" name="finalizar" class="btn btn-lg btn-primary mt-2">Finalizar
                            compra</button>
                    </form>
                </div>
                <?php

                if (isset($_POST['finalizar'])) {
                    if (empty($_SESSION['carrinho'])) {
                        echo "
                        <script>
                            Swal.fire({
                            title: 'Erro ao realizar compra!',
                            text: 'Você precisa de produtos no carrinho pra fazer uma compra!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                                    });
                        </script>";
                    } elseif (!isset($_SESSION['emailUsuario'])) {
                        echo "
                        <script>
                            Swal.fire({
                            title: 'Para continuar a compra faça login!',
                            icon: 'info',
                            confirmButtonText: 'OK',
                            didClose: () => {
                                window.location.href = 'login-cliente.php';
                                    }               
                            });
                        </script>";
                    } else {
                        $_SESSION['frete'] = $_POST['frete'];
                        $_SESSION['quantidadeTotal'] = $_POST['quantidadeTotal'];
                        $_SESSION['valorTotal'] = $_POST['valorTotal'];
                        echo "
                        <script>
                            Swal.fire({
                            title: 'Escolha uma forma de pagamento para prosseguir com a compra!',
                            icon: 'info',
                            confirmButtonText: 'OK',
                            didClose: () => {
                                window.location.href = 'forma-pagamento.php';
                                    }               
                            });
                        </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>