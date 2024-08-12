<?php
session_start();
$idConfeitaria = $_GET['c'];

include_once '../controller/controller-produto.php';
include_once '../controller/controller-personalizado.php';
include_once '../controller/controller-confeitaria.php';
include_once '../controller/controller-pedido.php';
$produtoController = new ControllerProduto();
$confeitariaController = new ControllerConfeitaria();
$personalizadoController = new ControllerPersonalizado();
$pedidoController = new ControllerPedido();
$confeitaria = $confeitariaController->viewPerfilConfeitaria($idConfeitaria);
$telefones = $confeitariaController->listTelefones($idConfeitaria);

$numProdutosCarrinho = 0;
if (isset($_SESSION['carrinho'])) {
    $numProdutosCarrinho = count($_SESSION['carrinho']);
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
    <link rel="stylesheet" href="assets/css/style-index.css">

    <!-- ===== Link Swiper's CSS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- ===== Fontawesome CDN Link ===== -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil da Confeitaria</title>
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
                    <ul class="nav-links">
                        <li><a href="meus-pedidos.php">Meus Pedidos</a></li>
                        <li><a href="chat-cliente.php?c=<?php echo $idConfeitaria ?>"><i class='fas fa-comments'
                                    style='font-size:20px'></i> Chat</a></li>
                        <li><a href="editar-cliente.php">Meus Dados</a></li>
                        <li><a href="../view/pedir-suporte.php">Suporte</a></li>
                        <li><a href="dashboard-cliente.php">Home</a></li>
                        <li style="position: relative;">
                            <a href="carrinho.php">
                                <i class="fa fa-shopping-cart" style="font-size:20px"></i>
                                <?php if ($numProdutosCarrinho > 0) { ?>
                                    <span class="cart-counter"><?php echo $numProdutosCarrinho; ?></span>
                                <?php } ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>

    <?php foreach ($confeitaria as $dados) { ?>
        <div class="profile-banner">
            <img src='../view-confeitaria/<?php echo $dados['imgConfeitaria']; ?>'
                alt='<?php echo $dados['nomeConfeitaria']; ?>'>
            <h1><?php echo $dados['nomeConfeitaria']; ?></h1>
            <div class="info">
                <div><i class="fas fa-map-marker-alt"></i> <span>Endereço:</span>
                    <?php echo $dados['logConfeitaria'] . ', Nº ' . $dados['numLocal'] . ' - ' . $dados['bairroConfeitaria'] . ', ' . $dados['cidadeConfeitaria'] . ' - ' . $dados['ufConfeitaria'] . ' - CEP: ' . $dados['cepConfeitaria']; ?>
                </div>
                <div><i class="fas fa-envelope"></i> <span>Email:</span> <?php echo $dados['emailUsuario']; ?></div>
                <div class="telefone-container">
                    <i class="fas fa-phone-alt"></i> <span>Fones:</span>
                    <?php if (empty($telefones)) {
                        echo 'Essa Confeitaria não cadastrou nenhum telefone!';
                        ?>
                    <?php } else { ?>
                        <?php foreach ($telefones as $fone) { ?>
                            <div class="telefone-item">
                                <?php
                                if ($fone['tipoTelefone'] == 'Whats App') {
                                    echo "<i class='fab fa-whatsapp icon-whatsapp'></i> ";
                                } elseif ($fone['tipoTelefone'] == 'Fixo') {
                                    echo "<i class='fas fa-home icon-fixo'></i> ";
                                } elseif ($fone['tipoTelefone'] == 'Celular') {
                                    echo "<i class='fas fa-mobile-alt icon-celular'></i> ";
                                }
                                echo $fone['numTelConfeitaria'];
                                ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>

    <?php
    $tiposProduto = $personalizadoController->viewMostraTipoProdutos($idConfeitaria);

    foreach ($tiposProduto as $tipoProduto) {
        $idTipoProduto = $tipoProduto['idTipoProduto'];
        $produtos = $personalizadoController->viewPersonalizadosConfeitaria($idConfeitaria, $idTipoProduto);
        ?>

        <div id="titulo">
            <h1><?php $nomes = $produtoController->viewTiposProdutos($idTipoProduto);
            foreach ($nomes as $n) {
                echo $n['tipoProduto'];
            } ?> Personalizáveis</h1>
        </div>

        <div class="carousel-2">
            <?php foreach ($produtos as $produto) { ?>
                <div class="card">
                    <a
                        href="pedir-personalizado.php?p=<?php echo $produto['idPersonalizado'] ?>&c=<?php echo $idConfeitaria ?>">
                        <div class="card-image">
                            <?php
                            echo "<img src='../view-confeitaria/" . $produto['imgPersonalizado'] . "' alt='" . $produto['nomePersonalizado'] . "'>";
                            ?>
                        </div>
                    </a>
                    <div class="card-text">
                        <h2 class="card-title"><?php echo $produto['nomePersonalizado'] ?></h2>
                        <p class="card-body"><?php echo $produto['descPersonalizado'] ?></p>
                        <p class="card-body">Peso: <?php echo $produto['peso'] ?>Kg</p>
                    </div>
                    <div class="card-price"><?php echo $produto['qtdPersonalizado'] ?></div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php
    $tiposProduto = $produtoController->viewMostraTipoProdutos($idConfeitaria);

    foreach ($tiposProduto as $tipoProduto) {
        $idTipoProduto = $tipoProduto['idTipoProduto'];
        $produtos = $produtoController->viewProdutosConfeitaria($idConfeitaria, $idTipoProduto);
        ?>

        <div id="titulo">
            <h1><?php $nomes = $produtoController->viewTiposProdutos($idTipoProduto);
            foreach ($nomes as $n) {
                echo $n['tipoProduto'];
            } ?> em destaque</h1>
        </div>

        <div class="carousel-2">
            <?php foreach ($produtos as $produto) { ?>
                <div class="card">
                    <div class="card-image">
                        <?php echo "<img src='../view-confeitaria/" . $produto['imgProduto'] . "' alt='" . $produto['nomeProduto'] . "'>"; ?>
                    </div>
                    </a>
                    <div class="card-text">
                        <h2 class="card-title"><?php echo $produto['nomeProduto'] ?></h2>
                        <p class="card-body"><?php echo $produto['descProduto'] ?></p>
                        <p class="card-body">Frete: R$<?php echo $produto['frete'] ?></p>
                    </div>
                    <div class="card-price">Preço: R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.') ?></div>
                    <form id="form" method="post">
                        <input id="id" type="hidden" name="id" value="<?php echo $produto['idProduto'] ?>">
                        <button type="submit" name="carrinho" id="carrinho" class="add-to-cart"><i
                                class="fa fa-shopping-cart"></i></button>
                    </form>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <?php
    if (isset($_POST['carrinho'])) {
        $resposta = $pedidoController->addCarrinho();
        if ($resposta == 'id_diferente') {
            echo "
                <script>
                    Swal.fire({
                    title: 'Erro ao adicionar Produto!',
                    text: 'Você só pode pedir produtos de uma confeitaria por vez!',
                    icon: 'info',
                    confirmButtonText: 'OK'
                    });
            </script>";
        } else if ($resposta == 'add') {
            echo "
                <script>
                    Swal.fire({
                    title: 'Produto adicionado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                        didClose: () => {
                                window.location.href = 'carrinho.php';
                            }
                    });
            </script>";
        }
    }
    ?>

    <br><br>

    <div id="container_ajuda">

        <h2>Ajuda</h2>
        <p>Se precisar de assistência, Aqui tem algumas perguntas frequentes.</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo2()"> 1 - Este Site é seguro?</p>

        <p id="paragrafo2"><br>Todas as transações são criptografadas para garantir segurança.</p>
        <p>__________________________________________________________________________</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo3()"> 2 - Como aplicar cupons de desconto?</p>

        <p id="paragrafo3"><br>Durante o checkout, há uma opção para inserir o código do cupom.</p>
        <p>__________________________________________________________________________</p>
        <br>
        <p id="paragrafo1" onclick="mostrarParagrafo4()"> 3 - Participação em promoções específicas?</p>

        <p id="paragrafo4"><br>Fique atento às nossas newsletters e redes sociais para informações sobre promoções
            especiais.</p>
        <p>__________________________________________________________________________</p>
    </div>

    <footer class="rodape">
        <p>© 2024 | Todos os direitos são de propriedade da FoxBitSystem</p>
    </footer>

    <script>
        function mostrarParagrafo2() {
            var paragrafo2 = document.getElementById("paragrafo2");
            paragrafo2.style.display = "block";

            var tempoExibicao = 3000; // Defina o tempo em milissegundos (exemplo: 3000 para 3 segundos)

            // Use setTimeout para ocultar o parágrafo após o tempo especificado
            setTimeout(function () {
                paragrafo2.style.display = "none";
            }, tempoExibicao);
        }

        function mostrarParagrafo3() {
            var paragrafo2 = document.getElementById("paragrafo3");
            paragrafo2.style.display = "block";

            var tempoExibicao = 3000; // Defina o tempo em milissegundos (exemplo: 3000 para 3 segundos)

            // Use setTimeout para ocultar o parágrafo após o tempo especificado
            setTimeout(function () {
                paragrafo2.style.display = "none";
            }, tempoExibicao);
        }

        function mostrarParagrafo4() {
            var paragrafo2 = document.getElementById("paragrafo4");
            paragrafo2.style.display = "block";

            var tempoExibicao = 3000; // Defina o tempo em milissegundos (exemplo: 3000 para 3 segundos)

            // Use setTimeout para ocultar o parágrafo após o tempo especificado
            setTimeout(function () {
                paragrafo2.style.display = "none";
            }, tempoExibicao);
        }

        // Função dos banner
        function nextSlide() {
            var slides = document.querySelectorAll('.slides .slide');
            var radios = document.querySelectorAll('[name="carousel"]');
            var currentIndex;

            for (var i = 0; i < radios.length; i++) { // Encontrar o índice do slide atual
                if (radios[i].checked) {
                    currentIndex = i;
                    break;
                }
            }

            radios[currentIndex].checked = false; // Desmarcar o slide atual e marcar o próximo slide
            if (currentIndex < slides.length - 1) {
                radios[currentIndex + 1].checked = true;
            } else {
                radios[0].checked = true; // Voltar para o primeiro slide se chegarmos ao último
            }
        }

        setInterval(nextSlide, 3000); // Definir intervalo para mudar de slide a cada 3 segundos (3000 milissegundos)
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.carousel-2').slick({
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const menuMobile = document.querySelector('.btn-menumobile');
            const navLinks = document.querySelector('.nav-links');

            menuMobile.addEventListener('click', function () {
                navLinks.classList.toggle('active');
            });
        });
    </script>

</body>

</html>