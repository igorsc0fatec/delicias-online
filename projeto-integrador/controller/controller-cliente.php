<?php
include_once '../model/dao.php';
include_once '../model/cliente.php';
include_once '../model/telefone.php';
include_once '../model/endereco.php';

class ControllerCliente
{
    private $dao;
    private $cliente;
    private $telefone;
    private $endereco;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->cliente = new Cliente();
        $this->telefone = new Telefone();
        $this->endereco = new Endereco();
    }

    public function addCliente()
    {
        try {
            $this->cliente->setNomeCliente($this->dao->escape_string($_POST['nomeCliente']));
            $this->cliente->setCpfCliente($this->dao->escape_string($_POST['cpfCliente']));
            $this->cliente->setNascCliente($this->dao->escape_string($_POST['nascCliente']));
            $this->endereco->setCep($this->dao->escape_string($_POST['cep']));
            $this->endereco->setLogradouro($this->dao->escape_string($_POST['logradouro']));
            $this->endereco->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->endereco->setBairro($this->dao->escape_string($_POST['bairro']));
            $this->endereco->setCidade($this->dao->escape_string($_POST['cidade']));
            $this->endereco->setUf($this->dao->escape_string($_POST['uf']));

            $idUsuario = $this->dao->getData("SELECT idUsuario FROM tbusuario ORDER BY idUsuario DESC LIMIT 1");
            $idUsuario = $idUsuario[0]['idUsuario'];

            $this->dao->execute("INSERT INTO tbcliente(nomeCliente, cpfCliente, nascCliente, idUsuario) VALUES('{$this->cliente->getNomeCliente()}','{$this->cliente->getCpfCliente()}','{$this->cliente->getNascCliente()}','$idUsuario')");

            $idCliente = $this->dao->getData("SELECT idCliente FROM tbcliente ORDER BY idCliente DESC LIMIT 1");
            $idCliente = $idCliente[0]['idCliente'];

            $result = $this->dao->execute("INSERT INTO tbenderecocliente(cepCliente, logCliente, numLocal, bairroCliente, cidadeCliente, ufCliente, idCliente) VALUES('{$this->endereco->getCep()}','{$this->endereco->getLogradouro()}','{$this->endereco->getNumLocal()}','{$this->endereco->getBairro()}','{$this->endereco->getCidade()}','{$this->endereco->getUf()}','$idCliente')");

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao adicionar o cliente: " . $e->getMessage();
            return false;
        }
    }

    public function verificaCPF()
    {
        try {
            $this->cliente->setCpfCliente($this->dao->escape_string($_POST['cpfCliente']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbcliente WHERE cpfCliente = '{$this->cliente->getCpfCliente()}'");
            foreach ($sql as $cpf) {
                if ($cpf['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o CPF: " . $e->getMessage();
        }
    }

    public function updateCliente()
    {
        try {
            $this->cliente->setNomeCliente($this->dao->escape_string($_POST['nomeCliente']));
            $this->cliente->setNascCliente($this->dao->escape_string($_POST['nascCliente']));
            $this->cliente->setCpfCliente($this->dao->escape_string($_POST['cpfCliente']));

            $result = $this->dao->execute("UPDATE tbcliente SET nomeCliente='{$this->cliente->getNomeCliente()}', nascCliente='{$this->cliente->getNascCliente()}', 
            cpfCliente='{$this->cliente->getCpfCliente()}' WHERE idCliente=$_SESSION[idCliente]");

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao editar cliente: " . $e->getMessage();
            return false;
        }
    }

    public function viewCliente()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbcliente WHERE idCliente=$_SESSION[idCliente]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao mostrar dados do cliente: " . $e->getMessage();
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
            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbtelcliente WHERE idCliente = $_SESSION[idCliente]");

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
            $tipoTelefone = $this->telefone->getTipoTelefone();

            $ddd = '/\((\d{2})\)/';
            if (preg_match($ddd, $telefone, $matches)) {
                $ddd = $matches[1];
            }

            $idDDD = $this->dao->getData("SELECT idDDD FROM tbddd WHERE ddd = '$ddd'");
            $idDDD = $idDDD[0]['idDDD'];

            $result = $this->dao->execute("INSERT INTO tbtelcliente(numTelCliente, idCliente, idDDD, idTipoTelefone) VALUES('$telefone','$_SESSION[idCliente]','$idDDD','$tipoTelefone')");

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
            $result = $this->dao->getData("SELECT tbtelcliente.*, tbtipotelefone.* FROM tbtelcliente 
            INNER JOIN tbtipotelefone ON tbtelcliente.idTipoTelefone = tbtipotelefone.idTipoTelefone WHERE tbtelcliente.idCliente=$_SESSION[idCliente]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar telefones: " . $e->getMessage();
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
            $query = "DELETE FROM tbtelcliente WHERE idTelCliente = $id";
            $result = $this->dao->delete($query);

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao excluir telefone: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEndereco()
    {
        try {
            $this->endereco->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->endereco->setCep($this->dao->escape_string($_POST['cep']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbenderecocliente WHERE numLocal = '{$this->endereco->getNumLocal()}' and cepCliente = '{$this->endereco->getCep()}' AND idCliente = $_SESSION[idCliente]");

            foreach ($sql as $endereco) {
                if ($endereco['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar endereço: " . $e->getMessage();
        }
    }

    public function verificaEditEndereco()
    {
        try {
            $this->endereco->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->endereco->setCep($this->dao->escape_string($_POST['cep']));
            $this->endereco->setId($this->dao->escape_string($_POST['id']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbenderecocliente WHERE numLocal = '{$this->endereco->getNumLocal()}' and cepCliente = '{$this->endereco->getCep()}' and idEnderecoCliente={$this->endereco->getId()}");

            foreach ($sql as $endereco) {
                if ($endereco['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar endereço: " . $e->getMessage();
        }
    }

    public function countEndereco()
    {
        try {
            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbenderecocliente WHERE idCliente = $_SESSION[idCliente]");

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

    public function addEndereco()
    {
        try {
            $this->endereco->setCep($this->dao->escape_string($_POST['cep']));
            $this->endereco->setLogradouro($this->dao->escape_string($_POST['logradouro']));
            $this->endereco->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->endereco->setBairro($this->dao->escape_string($_POST['bairro']));
            $this->endereco->setCidade($this->dao->escape_string($_POST['cidade']));
            $this->endereco->setUf($this->dao->escape_string($_POST['uf']));

            if (isset($_SESSION['idCliente'])) {
                $result = $this->dao->execute("INSERT INTO tbenderecocliente(cepCliente, logCliente, numLocal, bairroCliente, cidadeCliente, ufCliente, idCliente) VALUES('{$this->endereco->getCep()}','{$this->endereco->getLogradouro()}','{$this->endereco->getNumLocal()}',
        '{$this->endereco->getBairro()}','{$this->endereco->getCidade()}','{$this->endereco->getUf()}', {$_SESSION['idCliente']})");

                if ($result) {
                    return true;
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar endereço: " . $e->getMessage();
            return false;
        }
    }

    public function deleteEndereco($id)
    {
        try {
            $result = $this->dao->delete("DELETE FROM tbenderecocliente WHERE idEnderecoCliente = $id");
            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao excluir endereço: " . $e->getMessage();
            return false;
        }
    }

    public function updateEndereco()
    {
        try {
            $this->endereco->setId($this->dao->escape_string($_POST['id']));
            $this->endereco->setCep($this->dao->escape_string($_POST['cep']));
            $this->endereco->setLogradouro($this->dao->escape_string($_POST['logradouro']));
            $this->endereco->setNumLocal($this->dao->escape_string($_POST['numLocal']));
            $this->endereco->setBairro($this->dao->escape_string($_POST['bairro']));
            $this->endereco->setCidade($this->dao->escape_string($_POST['cidade']));
            $this->endereco->setUf($this->dao->escape_string($_POST['uf']));

            $result = $this->dao->execute("UPDATE tbenderecocliente SET cepCliente='{$this->endereco->getCep()}', logCliente='{$this->endereco->getLogradouro()}', numLocal='{$this->endereco->getNumLocal()}', bairroCliente='{$this->endereco->getBairro()}'
            , cidadeCliente='{$this->endereco->getCidade()}', ufCliente='{$this->endereco->getUf()}' WHERE idEnderecoCliente={$this->endereco->getId()}");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao editar endereço: " . $e->getMessage();
            return false;
        }
    }

    public function viewEndereco()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbenderecocliente where idCliente=$_SESSION[idCliente]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar endereços: " . $e->getMessage();
            return [];
        }
    }

}
