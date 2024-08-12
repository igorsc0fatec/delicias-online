<?php
include_once '../model/dao.php';
include_once '../model/mensagem.php';
include_once '../model/conversa.php';

class ControllerChat
{
    private $dao;
    private $mensagem;
    private $conversa;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->mensagem = new Mensagem();
        $this->conversa = new Conversa();
    }

    public function addMensagem()
    {
        try {
            date_default_timezone_set('America/Sao_Paulo');

            $this->mensagem->setMensagem($this->dao->escape_string($_POST['mensagem']));
            $this->mensagem->setHoraEnvio(date('Y-m-d H:i:s'));
            $this->mensagem->setIdRemetente($_SESSION['idUsuario']);
            $this->mensagem->setIdDestinatario($this->dao->escape_string($_POST['id']));

            $this->conversa->setIdPrincipal($_SESSION['idUsuario']);
            $this->conversa->setIdOutro($this->dao->escape_string($_POST['id']));
            $this->conversa->setDataCriacao(date('Y-m-d H:i:s'));

            $uploadDir = '../img-chat/';

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

            $sql = $this->dao->getData("SELECT idConversa FROM tbconversa WHERE idPrincipal = {$this->conversa->getIdPrincipal()} AND idOutro = {$this->conversa->getIdOutro()}");

            if (count($sql) < 1) {
                $this->dao->execute("INSERT INTO tbconversa (lido, criacao, idPrincipal, idOutro) VALUES ('n','{$this->conversa->getDataCriacao()}',
            {$this->conversa->getIdPrincipal()},{$this->conversa->getIdOutro()})");

                $this->dao->execute("INSERT INTO tbconversa (lido, criacao, idPrincipal, idOutro) VALUES ('y','{$this->conversa->getDataCriacao()}',
            {$this->conversa->getIdOutro()},{$this->conversa->getIdPrincipal()})");
            } else {
                $this->dao->execute("UPDATE tbconversa SET lido = 'y' WHERE idPrincipal = {$this->conversa->getIdPrincipal()} AND idOutro = {$this->conversa->getIdOutro()}");
            }

            $this->dao->execute("INSERT INTO tbmensagem (mensagem, imagem, dataEnvio, idRemetente, idDestinatario)
        VALUES ('{$this->mensagem->getMensagem()}','$imagem_url','{$this->mensagem->getHoraEnvio()}',{$this->mensagem->getIdRemetente()},{$this->mensagem->getIdDestinatario()})");

        } catch (Exception $e) {
            echo "Erro ao adicionar mensagem: " . $e->getMessage();
        }
    }

    public function buscaConfeitaria($id)
    {
        try {
            $idUsuario = $this->dao->getData("SELECT idUsuario FROM tbconfeitaria WHERE idConfeitaria = $id");
            return $idUsuario;
        } catch (Exception $e) {
            echo "Erro ao adicionar mensagem: " . $e->getMessage();
        }
    }

    public function buscaConversa($idUsuario)
    {
        try {
            $this->conversa->setIdOutro($idUsuario);

            $idClientes = $this->dao->getData("SELECT idPrincipal FROM tbconversa WHERE idOutro = {$this->conversa->getIdOutro()}");

            if (empty($idClientes)) {
                return [];
            }

            $idClientesArray = array_map(function ($cliente) {
                return $cliente['idPrincipal'];
            }, $idClientes);

            $idClientesList = implode(',', $idClientesArray);

            $clientesNomes = $this->dao->getData("SELECT cl.idUsuario, cl.nomeCliente
                                              FROM tbcliente cl
                                              WHERE cl.idUsuario IN ($idClientesList)");

            return $clientesNomes;

        } catch (Exception $e) {
            echo "Erro ao buscar conversas ativas: " . $e->getMessage();
        }
    }

    public function getMensagens($idUsuario1, $idUsuario2)
    {
        try {
            $sql = "SELECT mensagem, dataEnvio, idRemetente, idDestinatario, imagem 
            FROM tbmensagem 
            WHERE (idRemetente = $idUsuario1 AND idDestinatario = $idUsuario2) 
               OR (idRemetente = $idUsuario2 AND idDestinatario = $idUsuario1)
            ORDER BY dataEnvio ASC";
            return $this->dao->getData($sql);
        } catch (Exception $e) {
            echo "Erro ao buscar mensagens: " . $e->getMessage();
        }
    }

    function timing ($time)
    {
        $time = time() - $time; // to get the time since that moment
        var_dump($time);
        $time = ($time<1) ? 1 : $time;
        $tokens = array (
            31536000 => 'ano',
            2592000 => 'mês',
            604800 => 'semana',
            86400 => 'dia',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            if ($text == "segundo") {
                return "agora mesmo";
            }
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }

}