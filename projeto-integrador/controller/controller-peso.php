<?php
include_once '../model/dao.php';
include_once '../model/peso.php';

class ControllerPeso
{
    private $dao;
    private $peso;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->peso = new Peso();
    }

    public function addPeso()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->peso->setPeso($this->dao->escape_string($_POST['peso']));

                $result = $this->dao->execute("INSERT INTO tbpeso(peso, idConfeitaria) VALUES('{$this->peso->getPeso()}',$_SESSION[idConfeitaria])");

                if ($result) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar o peso: " . $e->getMessage();
            return false;
        }
    }

    public function verificaPeso()
    {
        try {
            $this->peso->setPeso($this->dao->escape_string($_POST['peso']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbpeso WHERE peso = '{$this->peso->getPeso()}' AND idConfeitaria=$_SESSION[idConfeitaria]");

            foreach ($sql as $registro) {
                if ($registro['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o peso: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditPeso()
    {
        try {
            $this->peso->setId($this->dao->escape_string($_POST['id']));
            $this->peso->setPeso($this->dao->escape_string($_POST['peso']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbpeso WHERE peso = '{$this->peso->getPeso()}' AND idPeso={$this->peso->getId()}");

            foreach ($sql as $registro) {
                if ($registro['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o peso: " . $e->getMessage();
            return false;
        }
    }

    public function viewPeso()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbpeso WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;

        } catch (Exception $e) {
            echo "Erro ao buscar o peso: " . $e->getMessage();
            return [];
        }
    }

    public function deletePeso($id)
    {
        try {
            $this->peso->setId($this->dao->escape_string($id));

            $result = $this->dao->delete("DELETE FROM tbpeso WHERE idPeso = {$this->peso->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar o peso: " . $e->getMessage();
            return false;
        }
    }

    public function updatePeso()
    {
        try {
            $this->peso->setId($this->dao->escape_string($_POST['id']));
            $this->peso->setPeso($this->dao->escape_string($_POST['peso']));

            $result = $this->dao->execute("UPDATE tbpeso SET peso='{$this->peso->getPeso()}' WHERE idPeso={$this->peso->getId()}");

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar o peso: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaPeso()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbpeso WHERE (peso LIKE '%$pesq%') AND idConfeitaria='$_SESSION[idConfeitaria]'";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro: " . $e->getMessage();
            return [];
        }
    }
}
?>