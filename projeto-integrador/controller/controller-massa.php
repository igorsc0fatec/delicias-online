<?php
include_once '../model/dao.php';
include_once '../model/massa.php';

class ControllerMassa
{
    private $dao;
    private $massa;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->massa = new Massa();
    }

    public function addMassa()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->massa->setDescMassa($this->dao->escape_string($_POST['descricao']));

                $result = $this->dao->execute("INSERT INTO tbmassa(descMassa, idConfeitaria) VALUES('{$this->massa->getDescMassa()}','$_SESSION[idConfeitaria]')");

                if ($result) {
                    return true;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao adicionar a massa: " . $e->getMessage();
            return false;
        }
    }

    public function verificaMassa()
    {
        try {
            $this->massa->setDescMassa($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbmassa WHERE descMassa = '{$this->massa->getDescMassa()}' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a massa: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditMassa()
    {
        try {
            $this->massa->setId($this->dao->escape_string($_POST['id']));
            $this->massa->setDescMassa($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbmassa WHERE descMassa = '{$this->massa->getDescMassa()}' AND idMassa={$this->massa->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a massa: " . $e->getMessage();
            return false;
        }
    }

    public function viewMassa()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbmassa WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar a massa: " . $e->getMessage();
            return [];
        }
    }

    public function deleteMassa($id)
    {
        try {
            $this->massa->setId($this->dao->escape_string($id));

            $result = $this->dao->delete("DELETE FROM tbmassa WHERE idMassa = {$this->massa->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar a massa: " . $e->getMessage();
            return false;
        }
    }

    public function updateMassa()
    {
        try {
            $this->massa->setId($this->dao->escape_string($_POST['id']));
            $this->massa->setDescMassa($this->dao->escape_string($_POST['descricao']));

            $query = "UPDATE tbmassa SET descMassa='{$this->massa->getDescMassa()}' WHERE idMassa={$this->massa->getId()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar massa: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaMassa()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbmassa where (descMassa LIKE '%$pesq%') AND idConfeitaria=$_SESSION[idConfeitaria]";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar massa: " . $e->getMessage();
        }
    }
}
?>