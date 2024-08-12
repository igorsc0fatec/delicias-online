<?php
include_once '../model/dao.php';
include_once '../model/decoracao.php';

class ControllerDecoracao
{
    private $dao;
    private $decoracao;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->decoracao = new Decoracao();
    }

    public function addDecoracao()
    {
        try {
            if (isset($_POST['submit'])) {
                $this->decoracao->setDescDecoracao($this->dao->escape_string($_POST['descricao']));

                $result = $this->dao->execute("INSERT INTO tbdecoracao(descDecoracao, idConfeitaria) VALUES('{$this->decoracao->getDescDecoracao()}',$_SESSION[idConfeitaria])");

                if ($result) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function verificaDecoracao()
    {
        try {
            $this->decoracao->setDescDecoracao($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbdecoracao WHERE descDecoracao = '{$this->decoracao->getDescDecoracao()}' AND idConfeitaria=$_SESSION[idConfeitaria]");
            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEditDecoracao()
    {
        try {
            $this->decoracao->setId($this->dao->escape_string($_POST['id']));
            $this->decoracao->setDescDecoracao($this->dao->escape_string($_POST['descricao']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbdecoracao WHERE descDecoracao = '{$this->decoracao->getDescDecoracao()}' AND idDecoracao={$this->decoracao->getId()}");

            foreach ($sql as $produto) {
                if ($produto['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao verificar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function viewDecoracao()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbdecoracao WHERE idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDecoracao($id)
    {
        try {
            $this->decoracao->setId($this->dao->escape_string($id));

            $result = $this->dao->delete("DELETE FROM tbdecoracao WHERE idDecoracao = {$this->decoracao->getId()}");
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function updateDecoracao()
    {
        try {
            $this->decoracao->setId($this->dao->escape_string($_POST['id']));
            $this->decoracao->setDescDecoracao($this->dao->escape_string($_POST['descricao']));

            $query = "UPDATE tbdecoracao SET descDecoracao='{$this->decoracao->getDescDecoracao()}' WHERE idDecoracao={$this->decoracao->getId()}";
            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function pesquisaDecoracao()
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $query = "SELECT * FROM tbdecoracao where (descDecoracao LIKE '%$pesq%') AND idConfeitaria=$_SESSION[idConfeitaria]";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar decoração: " . $e->getMessage();
            return [];
        }
    }
}
?>