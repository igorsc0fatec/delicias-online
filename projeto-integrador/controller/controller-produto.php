<?php
include_once '../model/dao.php';
include_once '../model/produto.php';

class ControllerProduto
{
    private $dao;
    private $produto;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->produto = new Produto();
    }

    public function addProduto()
    {
        try {
            $this->produto->setNomeProduto($this->dao->escape_string($_POST['nomeProduto']));
            $this->produto->setDescProduto($this->dao->escape_string($_POST['descProduto']));
            $this->produto->setValorProduto($this->dao->escape_string($_POST['valorProduto']));
            $this->produto->setFrete($this->dao->escape_string($_POST['frete']));
            $this->produto->setAtivoProduto(1);
            $this->produto->setIdTipoProduto($this->dao->escape_string($_POST['tiposProduto']));

            $uploadDir = 'img/img-produto/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_tmp = $_FILES['img']['tmp_name'];
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;

                if (move_uploaded_file($imagem_tmp, $imagem_path)) {
                    $imagem_url = $this->dao->escape_string($imagem_path);
                } else {
                    throw new Exception("Erro ao mover o arquivo de imagem.");
                }
            } else {
                $imagem_url = null;
            }

            $ativo = $this->produto->getAtivoProduto() ? 1 : 0;

            $result = $this->dao->execute("INSERT INTO tbproduto(nomeProduto, descProduto, valorProduto, frete, ativoProduto, imgProduto, idTipoProduto, idConfeitaria) VALUES('{$this->produto->getNomeProduto()}','{$this->produto->getDescProduto()}',
            '{$this->produto->getValorProduto()}','{$this->produto->getFrete()}',{$ativo},'$imagem_url',{$this->produto->getIdTipoProduto()}, $_SESSION[idConfeitaria])");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar produto: " . $e->getMessage();
            return false;
        }
    }

    public function verificaProduto()
    {
        try {
            $this->produto->setNomeProduto($this->dao->escape_string($_POST['nomeProduto']));
            $this->produto->setDescProduto($this->dao->escape_string($_POST['descProduto']));

            $uploadDir = 'img/img-produto/';

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;
            }

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbproduto WHERE nomeProduto = '{$this->produto->getNomeProduto()}' AND descProduto='{$this->produto->getDescProduto()}' 
            AND imgProduto='$imagem_path' AND idConfeitaria=$_SESSION[idConfeitaria]");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar produto: " . $e->getMessage();
        }
    }

    public function verificaEditProduto()
    {
        try {
            $this->produto->setNomeProduto($this->dao->escape_string($_POST['nomeProduto']));
            $this->produto->setDescProduto($this->dao->escape_string($_POST['descProduto']));
            $this->produto->setId($this->dao->escape_string($_POST['id']));

            $uploadDir = 'img/img-produto/';

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;
            }

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbproduto WHERE nomeProduto = '{$this->produto->getNomeProduto()}' AND descProduto='{$this->produto->getDescProduto()}' 
            AND imgProduto='$imagem_path' AND idProduto={$this->produto->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar produto: " . $e->getMessage();
        }
    }

    public function viewProduto()
    {
        try {
            if (isset($_SESSION['idConfeitaria'])) {
                $result = $this->dao->getData("SELECT p.*, tp.tipoProduto FROM tbproduto AS p INNER JOIN tbtipoproduto AS tp ON p.idTipoProduto = tp.idTipoProduto
            WHERE p.idConfeitaria = {$_SESSION['idConfeitaria']}");
                return $result;
            }
        } catch (Exception $e) {
            echo "Erro ao visualizar produto: " . $e->getMessage();
            return [];
        }
    }

    public function viewTipoProduto()
    {
        try {
            $query = "SELECT * FROM tbtipoproduto";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar o tipo produto: " . $e->getMessage();
            return null;
        }
    }

    public function updateProduto()
    {
        try {
            $this->produto->setId($this->dao->escape_string($_POST['id']));
            $this->produto->setNomeProduto($this->dao->escape_string($_POST['nomeProduto']));
            $this->produto->setDescProduto($this->dao->escape_string($_POST['descProduto']));
            $this->produto->setIdTipoProduto($this->dao->escape_string($_POST['tiposProduto']));
            $this->produto->setValorProduto($this->dao->escape_string($_POST['valorProduto']));
            $this->produto->setFrete($this->dao->escape_string($_POST['frete']));
            $this->produto->setAtivoProduto($_POST['ativo']);

            $uploadDir = 'img/img-produto/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_tmp = $_FILES['img']['tmp_name'];
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;

                // Movendo a imagem para o diretório desejado
                if (move_uploaded_file($imagem_tmp, $imagem_path)) {
                    $imagem_url = $uploadDir . $imagem_nome;
                } else {
                    throw new Exception("Erro ao mover o arquivo de imagem.");
                }
            } else {
                $imagem_url = null;
            }

            $ativo = $this->produto->getAtivoProduto() ? 1 : 0;

            $result = $this->dao->execute("UPDATE tbproduto SET nomeProduto='{$this->produto->getNomeProduto()}', descProduto='{$this->produto->getDescProduto()}', valorProduto = '{$this->produto->getValorProduto()}', frete = '{$this->produto->getFrete()}',
            ativoProduto = $ativo, imgProduto='$imagem_url', idTipoProduto={$this->produto->getIdTipoProduto()} WHERE idProduto={$this->produto->getId()}");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaProduto()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT p.*, tp.tipoProduto FROM tbproduto AS p 
          INNER JOIN tbtipoproduto AS tp ON p.idTipoProduto = tp.idTipoProduto
          WHERE p.nomeProduto LIKE '%$pesq%' AND p.idConfeitaria = '{$_SESSION['idConfeitaria']}'";

            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar: " . $e->getMessage();
            return [];
        }
    }

    public function viewProdutos($tipoProduto)
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbproduto WHERE idTipoProduto = $tipoProduto AND ativoProduto=1");
            shuffle($result);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar produtos: " . $e->getMessage();
        }
    }

    public function viewTiposProdutos($tipoProduto)
    {
        try {
            $result = $this->dao->getData("SELECT tipoProduto FROM tbtipoproduto WHERE idTipoProduto = $tipoProduto");
            shuffle($result);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar produtos: " . $e->getMessage();
        }
    }

    public function viewProdutosConfeitaria($id, $tipoProduto)
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbproduto WHERE idConfeitaria=$id AND idTipoProduto = $tipoProduto AND ativoProduto=1");
            shuffle($result);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar produtos: " . $e->getMessage();
        }
    }

    public function viewMostraTipoProdutos($idConfeitaria)
    {
        try {
            $result = $this->dao->getData("SELECT DISTINCT idTipoProduto FROM tbproduto 
            WHERE idConfeitaria = $idConfeitaria GROUP BY idTipoProduto");
            if (!empty(($result))) {
                return $result;
            } else {
                return [];
            }
        } catch (Exception $e) {
            echo "Erro ao visualizar idTipoProduto: " . $e->getMessage();
            return [];
        }
    }

    public function viewMostraTipoGlobal()
    {
        try {
            $result = $this->dao->getData("SELECT DISTINCT idTipoProduto FROM tbproduto  GROUP BY idTipoProduto");
            if (!empty(($result))) {
                return $result;
            } else {
                return [];
            }
        } catch (Exception $e) {
            echo "Erro ao visualizar idTipoProduto: " . $e->getMessage();
            return [];
        }
    }

    public function viewDadosProduto($idProduto)
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbproduto WHERE idProduto = $idProduto");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar produto: " . $e->getMessage();
            return [];
        }
    }

}
