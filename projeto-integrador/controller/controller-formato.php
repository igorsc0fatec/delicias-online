<?php
include_once '../model/dao.php';
include_once '../model/formato.php';

class ControllerFormato
{
    private $dao;
    private $formato;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->formato = new Formato();
    }

    public function addFormato()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->formato->setDescFormato($this->dao->escape_string($_POST['descricao']));

                $result = $this->dao->execute("INSERT INTO tbformato(descFormato, idConfeitaria) VALUES('{$this->formato->getDescFormato()}',$_SESSION[idConfeitaria])");

                if ($result) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar o formato: " . $e->getMessage();
            return false;
        }
    }

    public function verificaFormato()
    {
        try {
            $this->formato->setDescFormato($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbformato WHERE descFormato = '{$this->formato->getDescFormato()}' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o formato: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditFormato()
    {
        try {
            $this->formato->setId($this->dao->escape_string($_POST['id']));
            $this->formato->setDescFormato($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbformato WHERE descFormato = '{$this->formato->getDescFormato()}' AND idFormato={$this->formato->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar o formato: " . $e->getMessage();
            return false;
        }
    }

    public function viewFormato()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbformato WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar o formato: " . $e->getMessage();
            return [];
        } 
    }

    public function deleteFormato($id)
    {
        try {
            $this->formato->setId($this->dao->escape_string($id));

            $result = $this->dao->delete("DELETE FROM tbformato WHERE idFormato = {$this->formato->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar o formato: " . $e->getMessage();
            return false;
        } 
    }

    public function updateFormato()
    {
        try {
            $this->formato->setId($this->dao->escape_string($_POST['id']));
            $this->formato->setDescFormato($this->dao->escape_string($_POST['descricao']));

            $query = "UPDATE tbformato SET descFormato='{$this->formato->getDescFormato()}' WHERE idFormato={$this->formato->getId()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar o formato: " . $e->getMessage();
            return false;
        } 
    }

    public function pesquisaFormato()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbformato where (descFormato LIKE '%$pesq%') AND idConfeitaria=$_SESSION[idConfeitaria]";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar formato: " . $e->getMessage();
            return [];
        } 
    }
}
?>
