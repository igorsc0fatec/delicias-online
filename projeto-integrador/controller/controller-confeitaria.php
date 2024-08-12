<?php
include_once '../model/dao.php';
include_once '../model/confeitaria.php';
include_once '../model/telefone.php';

class ControllerConfeitaria
{
    private $dao;
    private $confeitaria;
    private $telefone;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->confeitaria = new Confeitaria();
        $this->telefone = new Telefone();
    }

    public function addConfeitaria()
    {
        try {
            $this->confeitaria->setNomeConfeitaria($this->dao->escape_string($_POST['nomeConfeitaria']));
            $this->confeitaria->setCnpjConfeitaria($this->dao->escape_string($_POST['cnpjConfeitaria']));
            $this->confeitaria->setCepConfeitaria($this->dao->escape_string($_POST['cep']));
            $this->confeitaria->setLogConfeitaria($this->dao->escape_string($_POST['logradouro']));
            $this->confeitaria->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->confeitaria->setBairroConfeitaria($this->dao->escape_string($_POST['bairro']));
            $this->confeitaria->setCidadeConfeitaria($this->dao->escape_string($_POST['cidade']));
            $this->confeitaria->setUfConfeitaria($this->dao->escape_string($_POST['uf']));

            $uploadDir = 'img/img-confeitaria/';

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

            $idUsuario = $this->dao->getData("SELECT idUsuario FROM tbusuario ORDER BY idUsuario DESC LIMIT 1");
            $idUsuario = $idUsuario[0]['idUsuario'];

            $result = $this->dao->execute("INSERT INTO tbconfeitaria(nomeConfeitaria, cnpjConfeitaria, cepConfeitaria, logConfeitaria, numLocal, bairroConfeitaria, cidadeConfeitaria, ufConfeitaria, imgConfeitaria, idUsuario) VALUES('{$this->confeitaria->getNomeConfeitaria()}','{$this->confeitaria->getCnpjConfeitaria()}','{$this->confeitaria->getCepConfeitaria()}'
            ,'{$this->confeitaria->getLogConfeitaria()}','{$this->confeitaria->getNumLocal()}','{$this->confeitaria->getBairroConfeitaria()}','{$this->confeitaria->getCidadeConfeitaria()}','{$this->confeitaria->getUfConfeitaria()}','$imagem_url','$idUsuario')");

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao adicionar confeitaria: " . $e->getMessage();
            return false;
        }
    }

    public function verificaCNPJ()
    {
        try {
            $this->confeitaria->setCnpjConfeitaria($this->dao->escape_string($_POST['cnpjConfeitaria']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbconfeitaria WHERE cnpjConfeitaria = '{$this->confeitaria->getCnpjConfeitaria()}'");
            foreach ($sql as $row) {
                $total = $row['total'];
                return $total > 0;
            }

        } catch (Exception $e) {
            echo "Erro ao verificar CNPJ: " . $e->getMessage();
        }
    }

    public function updateConfeitaria()
    {
        try {
            $this->confeitaria->setNomeConfeitaria($this->dao->escape_string($_POST['nomeConfeitaria']));
            $this->confeitaria->setCnpjConfeitaria($this->dao->escape_string($_POST['cnpjConfeitaria']));
            $this->confeitaria->setCepConfeitaria($this->dao->escape_string($_POST['cep']));
            $this->confeitaria->setLogConfeitaria($this->dao->escape_string($_POST['logradouro']));
            $this->confeitaria->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->confeitaria->setBairroConfeitaria($this->dao->escape_string($_POST['bairro']));
            $this->confeitaria->setCidadeConfeitaria($this->dao->escape_string($_POST['cidade']));
            $this->confeitaria->setUfConfeitaria($this->dao->escape_string($_POST['uf']));

            $uploadDir = 'img/img-confeitaria/';

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

            $result = $this->dao->execute("UPDATE tbconfeitaria SET nomeConfeitaria='{$this->confeitaria->getNomeConfeitaria()}', cnpjConfeitaria = '{$this->confeitaria->getCnpjConfeitaria()}', cepConfeitaria='{$this->confeitaria->getCepConfeitaria()}', logConfeitaria='{$this->confeitaria->getLogConfeitaria()}', numLocal='{$this->confeitaria->getNumLocal()}', 
            bairroConfeitaria='{$this->confeitaria->getBairroConfeitaria()}', cidadeConfeitaria='{$this->confeitaria->getCidadeConfeitaria()}', ufConfeitaria='{$this->confeitaria->getUfConfeitaria()}', imgConfeitaria='{$imagem_url}' WHERE idConfeitaria=$_SESSION[idConfeitaria]");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao editar confeitaria: " . $e->getMessage();
            return false;
        }
    }

    public function viewConfeitaria()
    {
        try {
            $result = $this->dao->getData("SELECT 
                            idConfeitaria,
                            nomeConfeitaria,
                            cnpjConfeitaria,
                            cepConfeitaria,
                            logConfeitaria,
                            numLocal,
                            bairroConfeitaria,
                            cidadeConfeitaria,
                            ufConfeitaria,
                            idUsuario FROM tbconfeitaria where idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao mostrar dados da confeitaria: " . $e->getMessage();
            return [];
        }
    }

    public function verificaTelefone()
    {
        try {
            $this->telefone->setNumTelefone($this->dao->escape_string($_POST['telefone']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM (
                SELECT numTelConfeitaria AS numTelefone FROM tbtelconfeitaria UNION ALL SELECT numTelCliente FROM tbtelcliente) AS allTelefones
            WHERE numTelefone = '{$this->telefone->getNumTelefone()}'");
            foreach ($sql as $row) {
                if ($row['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o telefone: " . $e->getMessage();
        }
    }

    public function verificaDDD()
    {
        try {
            $this->telefone->setNumTelefone($this->dao->escape_string($_POST['telefone']));
            $telefone = $this->telefone->getNumTelefone();

            $ddd = '/\((\d{2})\)/';
            if (preg_match($ddd, $telefone, $matches)) {
                $ddd = $matches[1];
            }

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbddd WHERE ddd = '$ddd'");
            foreach ($sql as $ddd) {
                if ($ddd['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o ddd: " . $e->getMessage();
        }
    }

    public function countTelefone()
    {
        try {
            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbtelconfeitaria WHERE idConfeitaria = $_SESSION[idConfeitaria]");

            foreach ($sql as $total) {
                if ($total['total'] >= 3) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao contar telefones: " . $e->getMessage();
            return false;
        }
    }

    public function addTelefone()
    {
        try {
            $this->telefone->setNumTelefone($this->dao->escape_string($_POST['telefone']));
            $this->telefone->setTipoTelefone($this->dao->escape_string($_POST['tipoTelefone']));

            $telefone = $this->telefone->getNumTelefone();

            $ddd = '/\((\d{2})\)/';
            if (preg_match($ddd, $telefone, $matches)) {
                $ddd = $matches[1];
            }

            $idDDD = $this->dao->getData("SELECT idDDD FROM tbddd WHERE ddd = '$ddd'");
            $idDDD = $idDDD[0]['idDDD'];

            $result = $this->dao->execute("INSERT INTO tbtelconfeitaria(numTelConfeitaria, idDDD, idConfeitaria, idTipoTelefone) VALUES('$telefone','$idDDD',$_SESSION[idConfeitaria],{$this->telefone->getTipoTelefone()})");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar telefone: " . $e->getMessage();
            return false;
        }
    }

    public function viewTelefone()
    {
        try {
            $result = $this->dao->getData("SELECT tbtelconfeitaria.*, tbtipotelefone.* FROM tbtelconfeitaria 
            INNER JOIN tbtipotelefone ON tbtelconfeitaria.idTipoTelefone = tbtipotelefone.idTipoTelefone WHERE tbtelconfeitaria.idConfeitaria=$_SESSION[idConfeitaria]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao mostrar dados do telefone: " . $e->getMessage();
            return [];
        }
    }

    public function viewTipoTelefone()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbtipotelefone");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao mostrar dados do tipo de telefone: " . $e->getMessage();
            return [];
        }
    }

    public function deleteTelefone($id)
    {
        try {
            $query = "DELETE FROM tbtelconfeitaria WHERE idTelConfeitaria = $id";
            $result = $this->dao->delete($query);
            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao deletar o telefone: " . $e->getMessage();
            return false;
        }
    }

    public function viewConfeitarias()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbconfeitaria");
            shuffle($result);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar confeitarias: " . $e->getMessage();
            return null;
        } finally {
            $this->dao->close();
        }
    }

    public function viewPerfilConfeitaria($id)
    {
        try {
            $result = $this->dao->getData("SELECT
            c.nomeConfeitaria,
            c.cepConfeitaria,
            c.logConfeitaria,
            c.numLocal,
            c.bairroConfeitaria,
            c.cidadeConfeitaria,
            c.ufConfeitaria,
            c.imgConfeitaria,
            u.emailUsuario
            FROM tbconfeitaria c
            JOIN tbusuario u ON c.idUsuario = u.idUsuario
            WHERE c.idConfeitaria = $id");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar confeitarias: " . $e->getMessage();
            return [];
        }
    }

    public function listTelefones($id)
    {
        try {
            $result = $this->dao->getData("SELECT tbtelconfeitaria.*, tbtipotelefone.* FROM tbtelconfeitaria 
            INNER JOIN tbtipotelefone ON tbtelconfeitaria.idTipoTelefone = tbtipotelefone.idTipoTelefone WHERE tbtelconfeitaria.idConfeitaria=$id");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao listar telefones: " . $e->getMessage();
            return null;
        }
    }

}
