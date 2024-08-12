<?php
include_once '../model/dao.php';
include_once '../model/recheio.php';

class ControllerRecheio
{
    private $dao;
    private $recheio;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->recheio = new Recheio();
    }

    public function addRecheio()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->recheio->setDescRecheio($this->dao->escape_string($_POST['descricao']));

                $result = $this->dao->execute("INSERT INTO tbrecheio(descRecheio, idConfeitaria) VALUES('{$this->recheio->getDescRecheio()}','$_SESSION[idConfeitaria]')");

                if ($result) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function verificaRecheio()
    {
        try {
            $this->recheio->setDescRecheio($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbrecheio WHERE descRecheio = '{$this->recheio->getDescRecheio()}' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditRecheio()
    {
        try {
            $this->recheio->setId($this->dao->escape_string($_POST['id']));
            $this->recheio->setDescRecheio($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbrecheio WHERE descRecheio = '{$this->recheio->getDescRecheio()}' AND idRecheio={$this->recheio->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function viewRecheio()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbrecheio WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function deleteRecheio($id)
    {
        try {
            $this->recheio->setId($this->dao->escape_string($id));

            $result = $this->dao->delete("DELETE FROM tbrecheio WHERE idRecheio = {$this->recheio->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function updateRecheio()
    {
        try {
            $this->recheio->setId($this->dao->escape_string($_POST['id']));
            $this->recheio->setDescRecheio($this->dao->escape_string($_POST['descricao']));

            $query = "UPDATE tbrecheio SET descRecheio='{$this->recheio->getDescRecheio()}' WHERE idRecheio={$this->recheio->getId()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaRecheio()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbrecheio where (descRecheio LIKE '%$pesq%') AND idConfeitaria=$_SESSION[idConfeitaria]";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar recheio: " . $e->getMessage();
        }
    }
}
?>
