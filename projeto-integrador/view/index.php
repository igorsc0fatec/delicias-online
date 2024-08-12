<?php
include_once '../controller/controller-produto.php';
include_once '../controller/controller-confeitaria.php';
$produtoController = new ControllerProduto();
$confeitariaController = new ControllerConfeitaria();

$confeitarias = $confeitariaController->viewConfeitarias();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="assets/css/style-menu.css"> <!-- esse style é do menu -->
  <link rel="stylesheet" href="assets/css/style-index.css"> <!-- esse style é do banner e do carroseel -->

  <!-- ===== Link Swiper's CSS ===== -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <!-- ===== Fontawesome CDN Link ===== -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://unpkg.com/scrollreveal"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delicias online</title>

</head>

<body>
  <div class="container">
    <header>
      <nav>
        <div class="nav-container">
          <a href="index.php">
            <img id="logo" src="../view-cliente/assets/img/logo.png" alt="JobFinder">
          </a>
          <i class="fas fa-bars btn-menumobile"></i>
          <ul class="nav-links">
            <li><a href="../view-cliente/login-cliente.php">Sou Cliente</a></li>
            <li><a href="../view-confeitaria/login-confeitaria.php">Sou Confeitaria</a></li>
            <li><a href="../view-cliente/carrinho.php"><i class="fa fa-shopping-cart" style="font-size:22px"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
  </div>

  <div class="carousel">
    <input type="radio" name="carousel" id="slide1" checked>
    <input type="radio" name="carousel" id="slide2">
    <input type="radio" name="carousel" id="slide3">
    <div class="slides">
      <div class="slide">
        <img src="../view-cliente/assets/img/Oferta3.png" alt="Slide 1">
      </div>
      <div class="slide">
        <img src="../view-cliente/assets/img/Oferta2.png" alt="Slide 2">
      </div>
      <div class="slide">
        <img src="../view-cliente/assets/img/Oferta1.png" alt="Slide 3">
      </div>
    </div>
    <div class="navigation">
      <label for="slide1"></label>
      <label for="slide2"></label>
      <label for="slide3"></label>
    </div>
  </div>

  <div id="header">
    <h1>Confeitarias em destaque</h1>
  </div>

  <div class="carousel-2">
    <?php foreach ($confeitarias as $confeitaria) { ?>
      <div class="card">
        <a href="../view-cliente/dados-confeitaria.php?c=<?php echo $confeitaria['idConfeitaria'] ?>">
          <div class="card-image">
            <?php
            echo "<img src='../view-confeitaria/" . $confeitaria['imgConfeitaria'] . "' alt='" . $confeitaria['nomeConfeitaria'] . "'>";
            ?>
          </div>
        </a>
        <div class="card-text">
          <h2 class="card-title"><?php echo $confeitaria['nomeConfeitaria'] ?></h2>
        </div>
      </div>
    <?php } ?>
  </div>

  <?php
  $tiposProduto = $produtoController->viewMostraTipoGlobal();

  foreach ($tiposProduto as $tipoProduto) {
    $idTipoProduto = $tipoProduto['idTipoProduto'];
    $produtos = $produtoController->viewProdutos($idTipoProduto);
    ?>

    <div id="header">
      <h1><?php $nomes = $produtoController->viewTiposProdutos($idTipoProduto);
      foreach ($nomes as $n) {
        echo $n['tipoProduto'];
      } ?> em destaque</h1>
    </div>

    <div class="carousel-2">
      <?php foreach ($produtos as $produto) { ?>
        <div class="card">
          <a href="../view-cliente/visualizar-produto.php?p=<?php echo $produto['idProduto'] ?>">
            <div class="card-image">
              <?php
              echo "<img src='../view-confeitaria/" . $produto['imgProduto'] . "' alt='" . $produto['nomeProduto'] . "'>";
              ?>
            </div>
          </a>
          <div class="card-text">
            <h2 class="card-title"><?php echo $produto['nomeProduto'] ?></h2>
            <p class="card-body"><?php echo $produto['descProduto'] ?></p>
          </div>
          <div class="card-price">R$ <?php echo number_format($produto['valorProduto'], 2, ',', '.') ?></div>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

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