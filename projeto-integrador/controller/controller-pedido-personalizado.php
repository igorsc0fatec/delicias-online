<?php
include_once '../model/dao.php';
include_once '../model/pedido-personalizado.php';

class ControllerPedidoPersonalizado
{
    private $dao;
    private $pedidoPersonalizado;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->pedidoPersonalizado = new PedidoPersonalizado();
    }

    public function addPedidoPersonalizado()
    {
        try {
            date_default_timezone_set('America/Sao_Paulo');

            $this->pedidoPersonalizado->setStatus("Pedido Recebido!");
            $this->pedidoPersonalizado->setDataPedido(date('Y-m-d'));
            $this->pedidoPersonalizado->setHoraPedido(date('H:i:s'));
            $this->pedidoPersonalizado->setIdMassa($this->dao->escape_string($_POST['descMassa']));
            $this->pedidoPersonalizado->setIdRecheio($this->dao->escape_string($_POST['descRecheio']));
            $this->pedidoPersonalizado->setIdCobertura($this->dao->escape_string($_POST['descCobertura']));
            $this->pedidoPersonalizado->setIdFormato($this->dao->escape_string($_POST['descFormato']));
            $this->pedidoPersonalizado->setIdDecoracao($this->dao->escape_string($_POST['descDecoracao']));
            $this->pedidoPersonalizado->setIdPersonalizado($this->dao->escape_string($_POST['idPersonalizado']));
            $this->pedidoPersonalizado->setIdCliente($_SESSION['idCliente']);

            $valorTotal = 0.00;
            $desconto = 0.00;
            $frete = 0.00;

            // Montando a consulta SQL para inserção
            $sql = "INSERT INTO tbpedidopersonalizado (
                    valorTotal, desconto, dataPedido, horaPedido, frete, idFormaPagamento, 
                    status, idMassa, idRecheio, idCobertura, idFormato, idDecoracao, 
                    idPersonalizado, idCliente
                ) 
                VALUES (
                    '$valorTotal', '$desconto', '{$this->pedidoPersonalizado->getDataPedido()}', 
                    '{$this->pedidoPersonalizado->getHoraPedido()}', '$frete', NULL, 
                    '{$this->pedidoPersonalizado->getStatus()}', '{$this->pedidoPersonalizado->getIdMassa()}', 
                    '{$this->pedidoPersonalizado->getIdRecheio()}', '{$this->pedidoPersonalizado->getIdCobertura()}', 
                    '{$this->pedidoPersonalizado->getIdFormato()}', '{$this->pedidoPersonalizado->getIdDecoracao()}', 
                    '{$this->pedidoPersonalizado->getIdPersonalizado()}', '{$this->pedidoPersonalizado->getIdCliente()}'
                )";

            $result = $this->dao->execute($sql);

            if ($result) {
                $idPedidoPersonalizado = $this->dao->getData("SELECT idPedidoPersonalizado FROM tbpedidopersonalizado ORDER BY idPedidoPersonalizado DESC LIMIT 1");
                $idPedidoPersonalizado = $idPedidoPersonalizado[0]['idPedidoPersonalizado'];
                return $idPedidoPersonalizado;
            } else {
                echo "<script language='javascript' type='text/javascript'> window.location.href='../view-cliente/pedir-personalizado.php'</script>";
            }
        } catch (Exception $e) {
            echo "Erro ao adicionar pedido personalizado: " . $e->getMessage();
            return false;
        }
    }

    public function viewCobertura($id)
    {
        try {
            $query = "SELECT * FROM tbcobertura WHERE idConfeitaria=$id";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar a cobertura: " . $e->getMessage();
            return false;
        }
    }

    public function viewDecoracao($id)
    {
        try {
            $query = "SELECT * FROM tbdecoracao WHERE idConfeitaria='$id'";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar a decoração: " . $e->getMessage();
            return false;
        }
    }

    public function viewFormato($id)
    {
        try {
            $query = "SELECT * FROM tbformato WHERE idConfeitaria=$id";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar o formato: " . $e->getMessage();
            return false;
        }
    }

    public function viewMassa($id)
    {
        try {
            $query = "SELECT * FROM tbmassa WHERE idConfeitaria=$id";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar a massa: " . $e->getMessage();
            return false;
        }
    }

    public function viewRecheio($id)
    {
        try {
            $query = "SELECT * FROM tbrecheio WHERE idConfeitaria=$id";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar o recheio: " . $e->getMessage();
            return false;
        }
    }

    public function viewPedidoPersonalizado($id)
    {
        try {
            $query = "
        SELECT 
            p.idPedidoPersonalizado,
            p.status,
            p.dataPedido,
            p.horaPedido,
            p.valorTotal,
            p.desconto,
            p.frete,
            p.idFormaPagamento,
            m.descMassa,
            r.descRecheio,
            c.descCobertura,
            f.descFormato,
            d.descDecoracao,
            pr.nomePersonalizado,
            cl.nomeCliente,
            cl.cpfCliente,
            conf.idConfeitaria,
            conf.nomeConfeitaria
        FROM tbpedidopersonalizado p
        JOIN tbmassa m ON p.idMassa = m.idMassa
        JOIN tbrecheio r ON p.idRecheio = r.idRecheio
        JOIN tbcobertura c ON p.idCobertura = c.idCobertura
        JOIN tbformato f ON p.idFormato = f.idFormato
        JOIN tbdecoracao d ON p.idDecoracao = d.idDecoracao
        JOIN tbpersonalizado pr ON p.idPersonalizado = pr.idPersonalizado
        JOIN tbconfeitaria conf ON pr.idConfeitaria = conf.idConfeitaria
        JOIN tbcliente cl ON p.idCliente = cl.idCliente
        WHERE p.idPedidoPersonalizado = $id";

            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar o pedido personalizado: " . $e->getMessage();
            return false;
        }
    }

    public function getPedidosPersonalizadosByCliente($idCliente)
    {
        try {
            $query = "
        SELECT 
            p.idPedidoPersonalizado,
            p.valorTotal,
            p.desconto,
            p.dataPedido,
            p.horaPedido,
            p.frete,
            p.idFormaPagamento,
            p.status,
            m.descMassa,
            r.descRecheio,
            c.descCobertura,
            f.descFormato,
            d.descDecoracao,
            pr.nomePersonalizado,
            pr.descPersonalizado,
            pr.imgPersonalizado,
            pr.qtdPersonalizado
        FROM tbpedidopersonalizado p
        JOIN tbmassa m ON p.idMassa = m.idMassa
        JOIN tbrecheio r ON p.idRecheio = r.idRecheio
        JOIN tbcobertura c ON p.idCobertura = c.idCobertura
        JOIN tbformato f ON p.idFormato = f.idFormato
        JOIN tbdecoracao d ON p.idDecoracao = d.idDecoracao
        JOIN tbpersonalizado pr ON p.idPersonalizado = pr.idPersonalizado
        WHERE p.idCliente = $idCliente";
            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar os pedidos personalizados: " . $e->getMessage();
            return [];
        }
    }

    public function getPedidosPersonalizadosByIdPedido($idPedidoPersonalizado)
    {
        try {
            $query = "
            SELECT 
                p.idPedidoPersonalizado,
                p.dataPedido,
                p.horaPedido,
                p.status,
                m.descMassa,
                r.descRecheio,
                c.descCobertura,
                f.descFormato,
                d.descDecoracao,
                pr.nomePersonalizado,
                pr.imgPersonalizado
            FROM tbpedidopersonalizado p
            JOIN tbmassa m ON p.idMassa = m.idMassa
            JOIN tbrecheio r ON p.idRecheio = r.idRecheio
            JOIN tbcobertura c ON p.idCobertura = c.idCobertura
            JOIN tbformato f ON p.idFormato = f.idFormato
            JOIN tbdecoracao d ON p.idDecoracao = d.idDecoracao
            JOIN tbpersonalizado pr ON p.idPersonalizado = pr.idPersonalizado
            WHERE p.idPedidoPersonalizado = $idPedidoPersonalizado";

            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar os pedidos personalizados: " . $e->getMessage();
            return false;
        }
    }

    public function getPersonalizadosByConfeitaria()
    {
        try {
            $idConfeitaria = $this->dao->escape_string($_SESSION['idConfeitaria']);

            $query = "
            SELECT 
                p.idPedidoPersonalizado,
                p.valorTotal,
                p.desconto,
                p.dataPedido,
                p.horaPedido,
                p.frete,
                p.idFormaPagamento,
                p.status,
                p.idPersonalizado,
                p.idCliente,
                cl.nomeCliente,
                u.idUsuario,
                m.descMassa,
                r.descRecheio,
                c.descCobertura,
                f.descFormato,
                d.descDecoracao,
                pr.nomePersonalizado,
                pr.imgPersonalizado
            FROM tbpedidopersonalizado p
            JOIN tbmassa m ON p.idMassa = m.idMassa
            JOIN tbrecheio r ON p.idRecheio = r.idRecheio
            JOIN tbcobertura c ON p.idCobertura = c.idCobertura
            JOIN tbformato f ON p.idFormato = f.idFormato
            JOIN tbdecoracao d ON p.idDecoracao = d.idDecoracao
            JOIN tbpersonalizado pr ON p.idPersonalizado = pr.idPersonalizado
            JOIN tbcliente cl ON p.idCliente = cl.idCliente
            JOIN tbconfeitaria conf ON pr.idConfeitaria = conf.idConfeitaria
            JOIN tbusuario u ON cl.idUsuario = u.idUsuario
            WHERE conf.idConfeitaria = $idConfeitaria AND p.status = 'Pedido Recebido!'";

            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar os pedidos personalizados: " . $e->getMessage();
            return false;
        }
    }

    public function cancelarPedidoPersonalizado()
    {
        try {
            $idPedidoEscaped = $this->dao->escape_string($_POST['idPedidoPersonalizado']);

            $this->dao->execute("UPDATE tbpedidopersonalizado SET status = 'Pedido Cancelado!' 
                WHERE idPedidoPersonalizado = '$idPedidoEscaped' AND status != 'Em Rota de Entrega!'");

            $sql = $this->dao->getData("SELECT status FROM tbpedidopersonalizado WHERE idPedidoPersonalizado = '$idPedidoEscaped'");

            if ($sql[0]['status'] == 'Pedido Cancelado!') {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo "Erro ao atualizar status do pedido: " . $e->getMessage();
            return false;
        }
    }

    public function buscarPedidosPersonalizados($idConfeitaria, $termoPesquisa)
    {
        try {
            $idConfeitaria = $this->dao->escape_string($idConfeitaria);
            $termoPesquisa = $this->dao->escape_string($termoPesquisa);
            $termoPesquisa = '%' . $termoPesquisa . '%';

            $query = "
                SELECT 
                    p.idPedidoPersonalizado,
                    p.valorTotal,
                    p.desconto,
                    p.dataPedido,
                    p.horaPedido,
                    p.frete,
                    p.idFormaPagamento,
                    p.status,
                    p.idPersonalizado,
                    p.idCliente,
                    cl.nomeCliente,
                    u.idUsuario,
                    m.descMassa,
                    r.descRecheio,
                    c.descCobertura,
                    f.descFormato,
                    d.descDecoracao,
                    pr.nomePersonalizado,
                    pr.imgPersonalizado
                FROM tbpedidopersonalizado p
                JOIN tbmassa m ON p.idMassa = m.idMassa
                JOIN tbrecheio r ON p.idRecheio = r.idRecheio
                JOIN tbcobertura c ON p.idCobertura = c.idCobertura
                JOIN tbformato f ON p.idFormato = f.idFormato
                JOIN tbdecoracao d ON p.idDecoracao = d.idDecoracao
                JOIN tbpersonalizado pr ON p.idPersonalizado = pr.idPersonalizado
                JOIN tbcliente cl ON p.idCliente = cl.idCliente
                JOIN tbconfeitaria conf ON pr.idConfeitaria = conf.idConfeitaria
                JOIN tbusuario u ON cl.idUsuario = u.idUsuario
                WHERE conf.idConfeitaria = '$idConfeitaria'
                AND p.idPedidoPersonalizado LIKE '$termoPesquisa'";

            $result = $this->dao->getData($query);
            return $result;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar os pedidos personalizados: " . $e->getMessage();
            return false;
        }
    }

    public function updatePedidoPersonalizado()
    {
        try {
            $this->pedidoPersonalizado->setValorTotal($this->dao->escape_string($_POST['valor']));
            $this->pedidoPersonalizado->setDesconto($this->dao->escape_string($_POST['desconto']));
            $this->pedidoPersonalizado->setFrete($this->dao->escape_string($_POST['frete']));
            $this->pedidoPersonalizado->setIdFormaPagamento($_POST['idForma']);
            $this->pedidoPersonalizado->setIdPedidoPersonalizado($this->dao->escape_string($_POST['id']));

            $query = "
                UPDATE tbpedidopersonalizado 
                SET valorTotal = {$this->pedidoPersonalizado->getValorTotal()}, desconto = {$this->pedidoPersonalizado->getDesconto()}, frete = {$this->pedidoPersonalizado->getFrete()},
                idFormaPagamento = {$this->pedidoPersonalizado->getIdFormaPagamento()}, status = 'Pedido em rota de entrega!' WHERE idPedidoPersonalizado = {$this->pedidoPersonalizado->getIdPedidoPersonalizado()}
            ";

            $result = $this->dao->execute($query);

            if ($result) {
                return true;
            }
        } catch (Exception $e) {
            echo "Ocorreu um erro ao buscar os pedidos personalizados: " . $e->getMessage();
            return false;
        }
    }
}
?>