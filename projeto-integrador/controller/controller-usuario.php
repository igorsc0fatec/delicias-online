<?php
include_once '../model/dao.php';
include_once '../model/usuario.php';
include_once '../model/email.php';
include_once '../model/suporte.php';
class ControllerUsuario
{
    private $dao;
    private $usuario;
    private $email;
    private $suporte;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->usuario = new Usuario();
        $this->email = new Email();
        $this->suporte = new Suporte();
    }

    public function addUsuario()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));
            $this->usuario->setSenhaUsuario($this->dao->escape_string($_POST['senhaUsuario']));
            $this->usuario->setDataCriacao(date('Y-m-d'));
            $this->usuario->setOnline(date('Y-m-d H:i:s'));
            $this->usuario->setIdTipoUsuario($this->dao->escape_string($_POST['msg']));
            $this->usuario->setContaAtiva(1);

            if ($this->usuario->getIdTipoUsuario() == 1) {
                $this->usuario->setEmailVerificado(1);
            } else {
                $this->usuario->setEmailVerificado(0);
            }

            $ativo = $this->usuario->isContaAtiva() ? 1 : 0;
            $verificado = $this->usuario->isEmailVerificado() ? 1 : 0;
            $criptoSenha = password_hash($this->usuario->getSenhaUsuario(), PASSWORD_DEFAULT);

            $result = $this->dao->execute("INSERT INTO tbusuario(emailUsuario, emailVerificado, contaAtiva, senhaUsuario, dataCriacao, online, idTipoUsuario) 
            VALUES('{$this->usuario->getEmailUsuario()}','$verificado','$ativo','$criptoSenha','{$this->usuario->getDataCriacao()}','{$this->usuario->getOnline()}',{$this->usuario->getIdTipoUsuario()})");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar o usuario: " . $e->getMessage();
            return false;
        }
    }

    public function verificaEmail()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbusuario WHERE emailUsuario = '{$this->usuario->getEmailUsuario()}'");
            foreach ($sql as $row) {
                if ($row['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o email: " . $e->getMessage();
        }
    }

    public function verificaEditEmail()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));

            $sql = $this->dao->getData("SELECT COUNT(*) as total FROM tbusuario WHERE emailUsuario = '{$this->usuario->getEmailUsuario()}' AND idUsuario=$_SESSION[idUsuario]");
            foreach ($sql as $row) {
                if ($row['total'] > 0) {
                    return true;
                } else {
                    return false;
                }
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o email: " . $e->getMessage();
        }
    }

    public function enviaEmail()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));
            $local = $this->dao->escape_string($_POST['msg']);

            $this->email->enviarEmail($this->usuario->getEmailUsuario(), $local);

        } catch (Exception $e) {
            echo "Erro ao enviar o email: " . $e->getMessage();
        }
    }

    public function validaEmail($email)
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($email));
            $this->usuario->setEmailVerificado(1);
            $verificado = $this->usuario->isEmailVerificado() ? 1 : 0;

            $result = $this->dao->execute("UPDATE tbusuario SET emailVerificado=$verificado WHERE emailUsuario='{$this->usuario->getEmailUsuario()}'");

            if ($result) {
                return true;
            }

        } catch (Exception $e) {
            echo "Erro ao validar o email: " . $e->getMessage();
            return false;
        }
    }

    public function verificaLogin()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));
            $this->usuario->setSenhaUsuario($this->dao->escape_string($_POST['senhaUsuario']));

            $sql = $this->dao->getData("SELECT * FROM tbusuario WHERE emailUsuario = '{$this->usuario->getEmailUsuario()}'");
            $this->usuario->setIdTipoUsuario($sql[0]['idTipoUsuario']);

            if (count($sql) >= 1) {
                if ($sql[0]['contaAtiva'] === "0") {
                    echo "<script language='javascript' type='text/javascript'> window.location.href='../view/conta-inativa.php?e={$this->usuario->getEmailUsuario()}&t={$this->usuario->getIdTipoUsuario()}'</script>";
                    return 0;
                } else if ($sql[0]['emailVerificado'] === "0") {
                    echo "<script language='javascript' type='text/javascript'> window.location.href='../view/usuario-nao-verificado.php?e={$this->usuario->getEmailUsuario()}&t={$this->usuario->getIdTipoUsuario()}'</script>";
                    return 0;
                } else if (password_verify($this->usuario->getSenhaUsuario(), $sql[0]['senhaUsuario'])) {
                    $this->usuario->setOnline(date('Y-m-d H:i:s'));
                    $this->dao->execute("UPDATE tbusuario SET online = '{$this->usuario->getOnline()}' WHERE emailUsuario = '{$this->usuario->getEmailUsuario()}'");
                    return $this->usuario->getIdTipoUsuario();
                } else {
                    return 4;
                }
            } else {
                return 5;
            }

        } catch (Exception $e) {
            echo "Erro ao verificar o login: " . $e->getMessage();
            return 0;
        }
    }

    public function armazenaSessao($tipoUsuario, $emailUsuario)
    {
        $this->usuario->setEmailUsuario($this->dao->escape_string($emailUsuario));
        $this->usuario->setIdTipoUsuario($this->dao->escape_string($tipoUsuario));

        $tipoUsuario = $this->usuario->getIdTipoUsuario();

        if ($tipoUsuario === 2) {
            $sql = $this->dao->getData("SELECT * FROM tbusuario INNER JOIN tbcliente ON tbusuario.idUsuario = tbcliente.idUsuario WHERE tbusuario.emailUsuario = '{$this->usuario->getEmailUsuario()}'");
            foreach ($sql as $dados) {
                $_SESSION['idUsuario'] = $dados['idUsuario'];
                $_SESSION['idCliente'] = $dados['idCliente'];
                $_SESSION['idTipoUsuario'] = $dados['idTipoUsuario'];
                $_SESSION['nome'] = $dados['nomeCliente'];
            }
        } else if ($tipoUsuario === 3) {
            $sql = $this->dao->getData("SELECT * FROM tbusuario INNER JOIN tbconfeitaria ON tbusuario.idUsuario = tbconfeitaria.idUsuario WHERE tbusuario.emailUsuario = '{$this->usuario->getEmailUsuario()}'");
            foreach ($sql as $dados) {
                $_SESSION['idUsuario'] = $dados['idUsuario'];
                $_SESSION['idConfeitaria'] = $dados['idConfeitaria'];
                $_SESSION['idTipoUsuario'] = $dados['idTipoUsuario'];
                $_SESSION['nome'] = $dados['nomeConfeitaria'];
            }
        } else if ($tipoUsuario === 1) {
            $sql = $this->dao->getData("SELECT * FROM tbusuario WHERE emailUsuario = '{$this->usuario->getEmailUsuario()}'");
            foreach ($sql as $dados) {
                $_SESSION['idRoot'] = $dados['idUsuario'];
                $_SESSION['idTipoUsuario'] = $dados['idTipoUsuario'];
            }
        }
    }

    public function viewUsuario()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbusuario where idUsuario=$_SESSION[idUsuario]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar o usuário: " . $e->getMessage();
            return null;
        }
    }

    public function updateUsuario($senhaUsuario, $emailUsuario)
    {
        try {
            $this->usuario->setSenhaUsuario($this->dao->escape_string($_SESSION['senhaUsuario']));
            $senha = $this->usuario->getSenhaUsuario();
            $criptoSenha = password_hash($senha, PASSWORD_DEFAULT);

            $result = $this->dao->execute("UPDATE tbusuario SET emailUsuario='$_SESSION[emailUsuario]', senhaUsuario='$criptoSenha' WHERE idUsuario=$_SESSION[idUsuario]");
            if ($result) {
                unset($_SESSION['senhaUsuario']);
                return true;
            }
            /*if ($_SESSION['idTipoUsuario'] === 2) {
                echo "<script language='javascript' type='text/javascript'> window.location.href='../view-cliente/editar-usuario-cliente.php'</script>";
            } else if ($_SESSION['idTipoUsuario'] === 3) {
                echo "<script language='javascript' type='text/javascript'> window.location.href='../view-confeitaria/editar-usuario-confeitaria.php'</script>";
            }*/
        } catch (Exception $e) {
            echo "Erro ao editar o usuário: " . $e->getMessage();
            return false;
        }
    }

    public function addNovaSenha()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));
            $this->usuario->setSenhaUsuario($this->dao->escape_string($_POST['senhaUsuario']));

            $criptoSenha = password_hash($this->usuario->getSenhaUsuario(), PASSWORD_DEFAULT);

            $result = $this->dao->execute("UPDATE tbusuario SET senhaUsuario='$criptoSenha' WHERE emailUsuario='{$this->usuario->getEmailUsuario()}'");
            if ($result) {
                echo '<script>alert("Senha alterada com sucesso!");</script>';
                $sql = $this->dao->getData("SELECT idTipoUsuario FROM tbusuario where emailUsuario='{$this->usuario->getEmailUsuario()}'");
                foreach ($sql as $voltar) {
                    if ($voltar['idTipoUsuario'] == 2) {
                        echo "<script language='javascript' type='text/javascript'>
            window.location.href='../view-cliente/login-cliente.php'</script>";
                    } else if ($voltar['idTipoUsuario'] == 3) {
                        echo "<script language='javascript' type='text/javascript'>
            window.location.href='../view-confeitaria/login-confeitaria.php'</script>";
                    }
                }
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar a nova senha: " . $e->getMessage();
            return null;
        }
    }

    public function desativaUsuario()
    {
        try {
            $this->usuario->setSenhaUsuario($this->dao->escape_string($_POST['senhaUsuario']));
            $this->usuario->setContaAtiva(0);

            $ativo = $this->usuario->isContaAtiva() ? 1 : 0;

            $sql = $this->dao->getData("SELECT senhaUsuario FROM tbusuario WHERE idUsuario=$_SESSION[idUsuario]");

            if (password_verify($this->usuario->getSenhaUsuario(), $sql[0]['senhaUsuario'])) {
                $sql = $this->dao->execute("UPDATE tbusuario SET contaAtiva='{$ativo}' WHERE idUsuario=$_SESSION[idUsuario]");
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Erro ao desativar a conta: " . $e->getMessage();
            return false;
        }
    }

    public function ativaUsuario()
    {
        try {
            $this->usuario->setEmailUsuario($this->dao->escape_string($_POST['emailUsuario']));
            $this->usuario->setContaAtiva(1);

            $ativo = $this->usuario->isContaAtiva() ? 1 : 0;

            $sql = $this->dao->execute("UPDATE tbusuario SET contaAtiva='{$ativo}' WHERE emailUsuario='{$this->usuario->getEmailUsuario()}'");
            if ($sql) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "Erro ao ativar a conta: " . $e->getMessage();
            return false;
        }
    }

    public function pedirSuporte()
    {
        try {
            $this->suporte->setTitulo($this->dao->escape_string($_POST['titulo']));
            $this->suporte->setDescSuporte($this->dao->escape_string($_POST['descSuporte']));
            $this->suporte->setIdTipoSuporte($this->dao->escape_string($_POST['tipoSuporte']));
            $this->suporte->setIdUsuario($_SESSION['idUsuario']);
            $this->suporte->setResolvido(0);

            $resolvido = $this->suporte->isResolvido() ? 1 : 0;

            $result = $this->dao->execute("INSERT INTO tbsuporte(titulo, descSuporte, resolvido, idTipoSuporte, idUsuario) VALUES('{$this->suporte->getTitulo()}','{$this->suporte->getDescSuporte()}',
            {$resolvido},{$this->suporte->getIdTipoSuporte()}, {$this->suporte->getIdUsuario()})");

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro ao pedir suporte: " . $e->getMessage();
            return false;
        }
    }

    public function viewTipoSuporte()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbtiposuporte WHERE idTipoUsuario=$_SESSION[idTipoUsuario]");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar o tipo de suporte: " . $e->getMessage();
            return null;
        }
    }

    public function viewSuporteConfeitaria()
    {
        try {
            $result = $this->dao->getData("SELECT tbsuporte.*, tbtiposuporte.idTipoUsuario, tbtiposuporte.tipoSuporte FROM tbsuporte 
            INNER JOIN tbtiposuporte ON tbsuporte.idTipoSuporte = tbtiposuporte.idTipoSuporte 
            WHERE tbtiposuporte.idTipoUsuario = 3 AND tbsuporte.resolvido = 0");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar o suporte: " . $e->getMessage();
            return null;
        }
    }

    public function viewSuporteCliente()
    {
        try {
            $result = $this->dao->getData("SELECT tbsuporte.*, tbtiposuporte.idTipoUsuario, tbtiposuporte.tipoSuporte FROM tbsuporte 
            INNER JOIN tbtiposuporte ON tbsuporte.idTipoSuporte = tbtiposuporte.idTipoSuporte 
            WHERE tbtiposuporte.idTipoUsuario = 2 AND tbsuporte.resolvido = 0");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar o suporte: " . $e->getMessage();
            return null;
        }
    }

    public function buscaUsuario()
    {
        try {
            $this->usuario->setIdUsuario($this->dao->escape_string($_POST['pesq']));

            $sql = $this->dao->getData("SELECT * FROM tbusuario WHERE idUsuario = {$this->usuario->getIdUsuario()}");
            if (!empty($sql)) {
                $this->armazenaSessao($sql[0]['idTipoUsuario'], $sql[0]['emailUsuario']);
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo "Erro ao armazenar usuario: " . $e->getMessage();
            return false;
        }
    }

    public function enviarFeedback()
    {
        try {
            $this->usuario->setIdUsuario($this->dao->escape_string($_POST['idUsuario']));
            $this->suporte->setDescSuporte($this->dao->escape_string($_POST['descSuporte']));
            $this->suporte->setIdSuporte($this->dao->escape_string($_POST['idSuporte']));
            $this->suporte->setResolvido(1);

            $verificado = $this->suporte->isResolvido() ? 1 : 0;

            $this->dao->execute("UPDATE tbsuporte SET resolvido = '$verificado' WHERE idSuporte='{$this->suporte->getIdSuporte()}'");
            $sql = $this->dao->getData("SELECT emailUsuario FROM tbusuario WHERE idUsuario = {$this->usuario->getIdUsuario()}");
            $this->email->enviarEmail($sql[0]['emailUsuario'], "feedback");
        } catch (Exception $e) {
            echo "Erro ao visualizar o suporte: " . $e->getMessage();
            return null;
        }
    }

    public function pesquisarSuporte($idTipoSuporte)
    {
        try {
            $pesq = $this->dao->escape_string($_POST['pesq']);
            $result = $this->dao->getData("SELECT s.*, ts.tipoSuporte FROM tbsuporte s INNER JOIN tbtiposuporte ts 
            ON s.idTipoSuporte = ts.idTipoSuporte WHERE s.nome LIKE '%$pesq%' AND ts.idTipoUsuario = $idTipoSuporte");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao pesquisar: " . $e->getMessage();
            return [];
        }
    }

    public function getDadosConfeitaria($idConfeitaria)
    {
        try {
            $sql = $this->dao->getData("
            SELECT 
                u.idUsuario, u.emailUsuario, u.emailVerificado, u.contaAtiva, u.senhaUsuario, 
                u.dataCriacao, u.online, u.idTipoUsuario,
                c.idConfeitaria, c.nomeConfeitaria, c.cnpjConfeitaria, c.cepConfeitaria, 
                c.logConfeitaria, c.numLocal, c.complemento, c.bairroConfeitaria, 
                c.cidadeConfeitaria, c.ufConfeitaria, c.imgConfeitaria
            FROM tbconfeitaria c
            INNER JOIN tbusuario u ON c.idUsuario = u.idUsuario
            WHERE c.idConfeitaria = {$this->dao->escape_string($idConfeitaria)}
        ");
            return $sql;
        } catch (Exception $e) {
            echo "Erro ao buscar os dados da confeitaria: " . $e->getMessage();
            return null;
        }
    }

    public function getDadosCliente($idCliente)
    {
        try {
            $sql = $this->dao->getData("
            SELECT 
                u.dataCriacao, u.online, 
                c.nomeCliente
            FROM tbusuario u
            INNER JOIN tbcliente c ON u.idUsuario = c.idUsuario
            WHERE c.idUsuario = {$this->dao->escape_string($idCliente)}
        ");
            return $sql;
        } catch (Exception $e) {
            echo "Erro ao buscar os dados do cliente: " . $e->getMessage();
            return null;
        }
    }

}
