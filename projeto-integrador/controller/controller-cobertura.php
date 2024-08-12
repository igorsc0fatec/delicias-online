<?php
include_once '../model/dao.php';
include_once '../model/cobertura.php';

class ControllerCobertura
{
    private $dao;
    private $cobertura;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->cobertura = new Cobertura();
    }

    public function addCobertura()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->cobertura->setDescCobertura($this->dao->escape_string($_POST['descricao']));

                $result = $this->dao->execute("INSERT INTO tbcobertura(descCobertura, idConfeitaria) VALUES('{$this->cobertura->getDescCobertura()}',$_SESSION[idConfeitaria])");

                if ($result) {
                    return true;
                }
            }
            $this->dao->close();
        } catch (Exception $e) {
            echo "Erro ao adicionar a cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function verificaCobertura()
    {
        try {
            $this->cobertura->setDescCobertura($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbcobertura WHERE descCobertura = '{$this->cobertura->getDescCobertura()}' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditCobertura()
    {
        try {
            $this->cobertura->setId($this->dao->escape_string($_POST['id']));
            $this->cobertura->setDescCobertura($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbcobertura WHERE descCobertura = '{$this->cobertura->getDescCobertura()}' AND idCobertura={$this->cobertura->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function viewCobertura()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbcobertura WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar a cobertura: " . $e->getMessage();
            return [];
        }
    }

    public function deleteCobertura($id)
    {
        try {
            $this->cobertura->setId($this->dao->escape_string($id));
            $result = $this->dao->delete("DELETE FROM tbcobertura WHERE idCobertura = {$this->cobertura->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar a cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function updateCobertura()
    {
        try {
            $this->cobertura->setId($this->dao->escape_string($_POST['id']));
            $this->cobertura->setDescCobertura($this->dao->escape_string($_POST['descricao']));

            $query = "UPDATE tbcobertura SET descCobertura='{$this->cobertura->getDescCobertura()}' WHERE idCobertura={$this->cobertura->getId()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaCobertura()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbcobertura where (descCobertura LIKE '%$pesq%') AND idConfeitaria=$_SESSION[idConfeitaria]";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar cobertura: " . $e->getMessage();
            return [];
        }
    }
}
?>