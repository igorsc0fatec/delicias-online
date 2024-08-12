<?php
include_once '../model/dao.php';
include_once '../model/personalizado.php';

class ControllerPersonalizado
{
    private $dao;
    private $personalizado;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->personalizado = new Personalizado();
    }

    public function addPersonalizado()
    {
        try {
            $this->personalizado->setNomePersonalizado($this->dao->escape_string($_POST['nomeProduto']));
            $this->personalizado->setDescPersonalizado($this->dao->escape_string($_POST['descPersonalizado']));
            $this->personalizado->setQtdPersonalizado($this->dao->escape_string($_POST['quantidade']));
            $this->personalizado->setIdPeso($this->dao->escape_string($_POST['peso']));
            $this->personalizado->setIdTipoProduto($this->dao->escape_string($_POST['tiposProduto']));
            $this->personalizado->setAtivoPersonalizado(1);

            $uploadDir = 'img/img-personalizado/';

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

            $ativo = $this->personalizado->getAtivoPersonalizado() ? 1 : 0;

            $result = $this->dao->execute("INSERT INTO tbpersonalizado(nomePersonalizado, descPersonalizado, imgPersonalizado, qtdPersonalizado, ativoPersonalizado, idPeso, idTipoProduto, idConfeitaria) VALUES('{$this->personalizado->getNomePersonalizado()}','{$this->personalizado->getDescPersonalizado()}'
            ,'$imagem_url',{$this->personalizado->getQtdPersonalizado()},{$ativo},{$this->personalizado->getIdPeso()},{$this->personalizado->getIdTipoProduto()},$_SESSION[idConfeitaria])");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao cadastrar personalizado: " . $e->getMessage();
            return false;
        }
    }

    public function verificaPersonalizado()
    {
        try {
            $this->personalizado->setNomePersonalizado($this->dao->escape_string($_POST['nomeProduto']));
            $this->personalizado->setDescPersonalizado($this->dao->escape_string($_POST['descPersonalizado']));

            $uploadDir = 'img/img-produto/';

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;
            }

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbpersonalizado WHERE nomePersonalizado = '{$this->personalizado->getNomePersonalizado()}' 
            AND descPersonalizado='{$this->personalizado->getDescPersonalizado()}' AND imgPersonalizado='$imagem_path' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar personalizado: " . $e->getMessage();
        }
    }

    public function verificaEditPersonalizado()
    {
        try {
            $this->personalizado->setNomePersonalizado($this->dao->escape_string($_POST['nomeProduto']));
            $this->personalizado->setDescPersonalizado($this->dao->escape_string($_POST['descPersonalizado']));
            $this->personalizado->setIdPersonalizado($this->dao->escape_string($_POST['id']));

            $uploadDir = 'img/img-produto/';

            if ($_FILES['img']['error'] == UPLOAD_ERR_OK) {
                $imagem_nome = basename($_FILES['img']['name']);
                $imagem_path = $uploadDir . $imagem_nome;
            }

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbpersonalizado WHERE nomePersonalizado = '{$this->personalizado->getNomePersonalizado()}' 
            AND descPersonalizado='{$this->personalizado->getDescPersonalizado()}' AND imgPersonalizado='$imagem_path' AND idPersonalizado={$this->personalizado->getIdPersonalizado()}");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar personalizado: " . $e->getMessage();
        }
    }

    public function viewPersonalizado()
    {
        try {
            if (isset($_SESSION['idConfeitaria'])) {
                $result = $this->dao->getData("SELECT pp.*, tp.tipoProduto, ps.peso FROM tbpersonalizado AS pp INNER JOIN tbtipoproduto AS tp ON pp.idTipoProduto = tp.idTipoProduto
            INNER JOIN tbpeso AS ps ON pp.idPeso = ps.idPeso
            WHERE pp.idConfeitaria = {$_SESSION['idConfeitaria']}");
                return $result;
            } else {
                echo '<script>alert("É necessario ter o ID do Usuario para realizar essa operação!")</script>';
                echo "<script language='javascript' type='text/javascript'>window.location.href='../view-root/confeitarias-root.php'</script>";
            }
        } catch (Exception $e) {
            echo "Erro ao visualizar produto: " . $e->getMessage();
            return [];
        }
    }

    public function viewTipoProduto()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbtipoproduto");
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . $e->getMessage();
            return null;
        }
    }

    public function viewPeso()
    {
        try {
            if (isset($_SESSION['idConfeitaria'])) {
                $result = $this->dao->getData("SELECT * FROM tbpeso WHERE idConfeitaria = $_SESSION[idConfeitaria]");
                return $result;
            }
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . $e->getMessage();
            return null;
        }
    }

    public function updatePersonalizado()
    {
        try {
            $this->personalizado->setIdPersonalizado($this->dao->escape_string($_POST['id']));
            $this->personalizado->setNomePersonalizado($this->dao->escape_string($_POST['nomeProduto']));
            $this->personalizado->setDescPersonalizado($this->dao->escape_string($_POST['descPersonalizado']));
            $this->personalizado->setQtdPersonalizado($this->dao->escape_string($_POST['quantidade']));
            $this->personalizado->setIdPeso($this->dao->escape_string($_POST['peso']));
            $this->personalizado->setIdTipoProduto($this->dao->escape_string($_POST['tiposProduto']));
            $this->personalizado->setAtivoPersonalizado($_POST['ativo']);

            $uploadDir = 'img/img-personalizado/';

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

            $ativo = $this->personalizado->getAtivoPersonalizado() ? 1 : 0;

            $query = "UPDATE tbpersonalizado SET nomePersonalizado='{$this->personalizado->getNomePersonalizado()}', descPersonalizado='{$this->personalizado->getDescPersonalizado()}', imgPersonalizado = '$imagem_url', 
            qtdPersonalizado = {$this->personalizado->getQtdPersonalizado()}, ativoPersonalizado = $ativo, idPeso = {$this->personalizado->getIdPeso()}, idTipoProduto = {$this->personalizado->getIdTipoProduto()} WHERE idPersonalizado={$this->personalizado->getIdPersonalizado()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao editar personalizado: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaPersonalizado()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);

            $result = $this->dao->getData("SELECT pp.*, tp.tipoProduto, ps.peso FROM tbpersonalizado AS pp INNER JOIN tbtipoproduto AS tp ON pp.idTipoProduto = tp.idTipoProduto
            INNER JOIN tbpeso AS ps ON pp.idPeso = ps.idPeso
            WHERE pp.nomePersonalizado LIKE '%$pesq%' AND pp.idConfeitaria = {$_SESSION['idConfeitaria']}");

            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar personalizado: " . $e->getMessage();
            return [];
        }
    }

    public function viewPersonalizadosConfeitaria($id, $tipoProduto)
    {
        try {
            $result = $this->dao->getData("SELECT tbpersonalizado.*, tbpeso.peso FROM tbpersonalizado
            INNER JOIN tbpeso ON tbpersonalizado.idPeso = tbpeso.idPeso
            WHERE tbpersonalizado.idConfeitaria = $id AND tbpersonalizado.idTipoProduto = $tipoProduto AND ativoPersonalizado=1");
            shuffle($result);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar personalizados: " . $e->getMessage();
        }
    }

    public function viewMostraTipoProdutos($idConfeitaria)
    {
        try {
            $result = $this->dao->getData("SELECT DISTINCT idTipoProduto FROM tbpersonalizado 
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

    public function viewDadosPersonalizado($idPersonalizado)
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbpersonalizado WHERE idPersonalizado = $idPersonalizado");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar personalizado: " . $e->getMessage();
        }
    }

}
