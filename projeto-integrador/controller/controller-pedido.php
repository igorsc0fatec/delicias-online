<?php
include_once '../model/dao.php';
include_once '../model/pedido.php';
include_once '../model/itens-pedido.php';
include_once '../model/pagamento.php';

class ControllerPedido
{
    private $dao;
    private $pedido;
    private $itensPedido;
    private $pagamento;

    public function __construct()
    {
        $this->dao = new DAO();
        $this->pedido = new Pedido();
        $this->itensPedido = new ItensPedido();
        $this->pagamento = new Pagamento();
    }

    public function addPedido()
    {
        try {
            date_default_timezone_set('America/Sao_Paulo');

            $carrinho = $_SESSION['carrinho'];
            $valorTotal = 0;
            $frete = 0;

            foreach ($carrinho as $produto) {
                if (is_array($produto) && isset($produto['frete']) && isset($produto['valorProduto']) && isset($produto['quantidade'])) {
                    $frete = $produto['frete'];
                    $valorTotal += $produto['valorProduto'] * $produto['quantidade'];
                    $valorTotal = $valorTotal + $frete;
                }
            }

            $this->pedido->setValorTotal($valorTotal);
            $this->pedido->setDesconto(0);
            $this->pedido->setDataPedido(date('Y-m-d'));
            $this->pedido->setHoraPedido(date('H:i:s'));
            $this->pedido->setFrete($frete);
            $this->pedido->setStatus($this->dao->escape_string("Pedido Recebido!"));
            $this->pedido->setIdCliente($this->dao->escape_string($_SESSION['idCliente']));
            $this->pedido->setIdFormaPagamento($this->dao->escape_string($_POST['formaPagamento']));
            $this->pedido->setIdEnderecoCliente($this->dao->escape_string($_POST['endereco']));

            $result = $this->dao->execute("INSERT INTO tbpedido (valorTotal, desconto, dataPedido, horaPedido, frete, status, idCliente, idFormaPagamento, idEnderecoCliente) VALUES (
        {$this->pedido->getValorTotal()},{$this->pedido->getDesconto()},'{$this->pedido->getDataPedido()}','{$this->pedido->getHoraPedido()}',
        {$this->pedido->getFrete()},'{$this->pedido->getStatus()}',{$this->pedido->getIdCliente()},{$this->pedido->getIdFormaPagamento()}, 
        {$this->pedido->getIdEnderecoCliente()})");

            if ($result) {
                $idPedido = $this->dao->getData("SELECT idPedido FROM tbpedido ORDER BY idPedido DESC LIMIT 1");
                $idPedido = $idPedido[0]['idPedido'];
                return $idPedido;
            }
        } catch (Exception $e) {
            echo "Erro ao fazer o pedido: " . $e->getMessage();
            return 0;
        }
    }

    public function addItensPedido($idPedido)
    {
        try {
            $carrinho = $_SESSION['carrinho'];
            $totalItens = count($carrinho);
            $count = 0;

            foreach ($carrinho as $produto) {
                $this->itensPedido->setIdProduto($this->dao->escape_string($produto['idProduto']));
                $this->itensPedido->setIdPedido($this->dao->escape_string($idPedido));
                $this->itensPedido->setQuantidade($this->dao->escape_string($produto['quantidade']));

                $query = "INSERT INTO tbitenspedido (idProduto, idPedido, quantidade) VALUES (
                {$this->itensPedido->getIdProduto()},
                {$this->itensPedido->getIdPedido()},
                {$this->itensPedido->getQuantidade()}
            )";

                $result = $this->dao->execute($query);

                if ($result) {
                    $count++;
                }
            }

            if (($count) == $totalItens) {
                unset($_SESSION['carrinho']);
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            echo "Erro ao adicionar item ao pedido: " . $e->getMessage();
            return false;
        }
    }

    public function formaPagamento()
    {
        try {
            $result = $this->dao->getData("SELECT * FROM tbformapagamento");
            return $result;
        } catch (Exception $e) {
            echo "Erro ao visualizar produto: " . $e->getMessage();
            return [];
        }
    }

    public function viewPedido($idPedido)
    {
        try {
            $pedidoQuery = "
        SELECT p.*, c.nomeCliente, c.cpfCliente, f.formaPagamento, ec.*
        FROM tbpedido p
        INNER JOIN tbcliente c ON p.idCliente = c.idCliente
        INNER JOIN tbformapagamento f ON p.idFormaPagamento = f.idFormaPagamento
        INNER JOIN tbenderecocliente ec ON p.idEnderecoCliente = ec.idEnderecoCliente
        WHERE p.idPedido = {$this->dao->escape_string($idPedido)}";
            $pedidoResult = $this->dao->getData($pedidoQuery);

            $itensQuery = "
        SELECT i.*, pr.nomeProduto, pr.imgProduto 
        FROM tbitenspedido i 
        INNER JOIN tbproduto pr ON i.idProduto = pr.idProduto
        WHERE i.idPedido = {$this->dao->escape_string($idPedido)}";
            $itensResult = $this->dao->getData($itensQuery);

            return [
                'pedido' => $pedidoResult,
                'itens' => $itensResult
            ];
        } catch (Exception $e) {
            echo "Erro ao visualizar pedido: " . $e->getMessage();
            return [];
        }
    }

    public function getIdConfeitariaByProduto($idProduto)
    {
        try {
            $query = "SELECT idConfeitaria FROM tbproduto WHERE idProduto = {$this->dao->escape_string($idProduto)}";
            $result = $this->dao->getData($query);
            if (!empty($result)) {
                return $result[0]['idConfeitaria'];
            }
        } catch (Exception $e) {
            echo "Erro ao obter idConfeitaria: " . $e->getMessage();
        }
        return null;
    }

    public function getPedidosByCliente($idCliente)
    {
        try {
            // Consulta para buscar todos os pedidos do cliente
            $pedidoQuery = "
            SELECT p.*, c.nomeCliente, c.cpfCliente, f.formaPagamento, ec.*
            FROM tbpedido p
            INNER JOIN tbcliente c ON p.idCliente = c.idCliente
            INNER JOIN tbformapagamento f ON p.idFormaPagamento = f.idFormaPagamento
            INNER JOIN tbenderecocliente ec ON p.idEnderecoCliente = ec.idEnderecoCliente
            WHERE p.idCliente = {$this->dao->escape_string($idCliente)}
            ORDER BY p.idPedido DESC"; // Ordena por ID do pedido, do mais recente ao mais antigo

            $pedidosResult = $this->dao->getData($pedidoQuery);

            // Array para armazenar os resultados finais
            $pedidos = [];

            // Itera sobre cada pedido encontrado
            foreach ($pedidosResult as $pedido) {
                // Consulta para buscar os itens do pedido atual
                $itensQuery = "
                SELECT i.*, pr.nomeProduto, pr.imgProduto 
                FROM tbitenspedido i 
                INNER JOIN tbproduto pr ON i.idProduto = pr.idProduto
                WHERE i.idPedido = {$this->dao->escape_string($pedido['idPedido'])}";

                $itensResult = $this->dao->getData($itensQuery);

                // Adiciona os detalhes do pedido e seus itens ao array final de pedidos
                $pedidos[] = [
                    'pedido' => $pedido,
                    'itens' => $itensResult
                ];
            }

            return $pedidos;

        } catch (Exception $e) {
            echo "Erro ao visualizar pedidos: " . $e->getMessage();
            return [];
        }
    }

    public function getPedidosByConfeitaria()
    {
        try {
            $idConfeitaria = $this->dao->escape_string($_SESSION['idConfeitaria']);

            $query = "
        SELECT DISTINCT
            tbpedido.idPedido,
            tbpedido.valorTotal,
            tbpedido.dataPedido,
            tbpedido.horaPedido,
            tbformapagamento.formaPagamento,
            tbcliente.nomeCliente
        FROM 
            tbpedido
        JOIN 
            tbformapagamento ON tbpedido.idFormaPagamento = tbformapagamento.idFormaPagamento
        JOIN 
            tbcliente ON tbpedido.idCliente = tbcliente.idCliente
        WHERE 
            tbpedido.idPedido IN (
                SELECT 
                    tbitenspedido.idPedido
                FROM 
                    tbitenspedido
                JOIN 
                    tbproduto ON tbitenspedido.idProduto = tbproduto.idProduto
                WHERE 
                    tbproduto.idConfeitaria = '$idConfeitaria' AND tbpedido.status = 'Pedido Recebido!'
            )
    ";

            $result = $this->dao->getData($query);

            return $result;
        } catch (Exception $e) {
            echo "Erro ao obter pedidos da confeitaria: " . $e->getMessage();
            return [];
        }
    }

    public function iniciarEntrega($idPedido)
    {
        try {
            $idPedidoEscaped = $this->dao->escape_string($idPedido);

            $query = "
                UPDATE tbpedido 
                SET status = 'Em Processo de Entrega!' 
                WHERE idPedido = '$idPedidoEscaped'
            ";

            $this->dao->execute($query);

        } catch (Exception $e) {
            echo "Erro ao atualizar status do pedido: " . $e->getMessage();
        }
    }

    public function cancelarPedido()
    {
        try {
            $idPedidoEscaped = $this->dao->escape_string($_POST['idPedido']);

            $this->dao->execute("UPDATE tbpedido SET status = 'Pedido Cancelado!' 
            WHERE idPedido = '$idPedidoEscaped' AND status != 'Em Rota de Entrega!'");

            $sql = $this->dao->getData("SELECT status FROM tbpedido WHERE idPedido = '$idPedidoEscaped'");
            
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

    public function confirmarPedido($idPedido)
    {
        try {
            $idPedidoEscaped = $this->dao->escape_string($idPedido);

            $sql = $this->dao->getData("SELECT status FROM tbpedido WHERE idPedido = $idPedidoEscaped");

            if ($sql[0]['status'] == 'Pedido Cancelado!') {
                echo "<script>alert('Esse pedido foi cancelado!')</script>";
            } else if ($sql[0]['status'] == 'Pedido Entregue!') {
                echo "<script>alert('Esse pedido já foi entregue!')</script>";
            } else {
                $query = "
                UPDATE tbpedido 
                SET status = 'Pedido Entregue!' 
                WHERE idPedido = '$idPedidoEscaped'
            ";

                $result = $this->dao->execute($query);

                if ($result) {
                    echo "<script>alert('Pedido entregue com sucesso!')</script>";
                }
            }

        } catch (Exception $e) {
            echo "Erro ao atualizar status do pedido: " . $e->getMessage();
        }
    }

    public function getProdutosNormaisMaisVendidos()
    {
        try {
            $query = "
        SELECT 
            p.idProduto,
            p.nomeProduto,
            SUM(i.quantidade) AS totalVendido
        FROM 
            tbitenspedido i
        INNER JOIN 
            tbproduto p ON i.idProduto = p.idProduto
        GROUP BY 
            i.idProduto
        ORDER BY 
            totalVendido DESC
        LIMIT 5";

            $result = $this->dao->getData($query);

            return $result;
        } catch (Exception $e) {
            echo "Erro ao obter produtos normais mais vendidos: " . $e->getMessage();
            return [];
        }
    }

    public function getProdutosPersonalizadosMaisVendidos()
    {
        try {
            $query = "
        SELECT 
            p.idPersonalizado,
            p.nomePersonalizado,
            COUNT(p.idPersonalizado) AS totalVendido
        FROM 
            tbpedidopersonalizado pd
        INNER JOIN 
            tbpersonalizado p ON pd.idPersonalizado = p.idPersonalizado
        GROUP BY 
            p.idPersonalizado, p.nomePersonalizado
        ORDER BY 
            totalVendido DESC
        LIMIT 5";

            $result = $this->dao->getData($query);

            return $result;
        } catch (Exception $e) {
            echo "Erro ao obter produtos personalizados mais vendidos: " . $e->getMessage();
            return [];
        }
    }

    public function getPedidosConfeitaria($idConfeitaria)
    {
        try {
            $idConfeitaria = $this->dao->escape_string($idConfeitaria);

            $query = "
        SELECT DISTINCT
            tbpedido.idPedido,
            tbpedido.valorTotal,
            tbpedido.dataPedido,
            tbpedido.horaPedido,
            tbpedido.status,
            tbformapagamento.formaPagamento,
            tbcliente.nomeCliente,
            tbproduto.nomeProduto,
            tbproduto.descProduto,
            tbitenspedido.quantidade
        FROM 
            tbpedido
        JOIN 
            tbformapagamento ON tbpedido.idFormaPagamento = tbformapagamento.idFormaPagamento
        JOIN 
            tbcliente ON tbpedido.idCliente = tbcliente.idCliente
        JOIN 
            tbitenspedido ON tbpedido.idPedido = tbitenspedido.idPedido
        JOIN 
            tbproduto ON tbitenspedido.idProduto = tbproduto.idProduto
        WHERE 
            tbproduto.idConfeitaria = '$idConfeitaria'
        ";

            $result = $this->dao->getData($query);

            return $result;
        } catch (Exception $e) {
            echo "Erro ao obter pedidos da confeitaria: " . $e->getMessage();
            return [];
        }
    }

    public function buscarPedidosConfeitaria($idConfeitaria, $termo)
    {
        try {
            $idConfeitaria = $this->dao->escape_string($idConfeitaria);
            $termo = $this->dao->escape_string($termo);

            $query = "
        SELECT DISTINCT
            tbpedido.idPedido,
            tbpedido.valorTotal,
            tbpedido.dataPedido,
            tbpedido.horaPedido,
            tbpedido.status,
            tbformapagamento.formaPagamento,
            tbcliente.nomeCliente,
            tbproduto.nomeProduto,
            tbproduto.descProduto,
            tbitenspedido.quantidade
        FROM 
            tbpedido
        JOIN 
            tbformapagamento ON tbpedido.idFormaPagamento = tbformapagamento.idFormaPagamento
        JOIN 
            tbcliente ON tbpedido.idCliente = tbcliente.idCliente
        JOIN 
            tbitenspedido ON tbpedido.idPedido = tbitenspedido.idPedido
        JOIN 
            tbproduto ON tbitenspedido.idProduto = tbproduto.idProduto
        WHERE 
            tbproduto.idConfeitaria = '$idConfeitaria'
            AND (
                tbpedido.idPedido LIKE '%$termo%'
                OR tbpedido.status LIKE '%$termo%'
            )
        ";

            $result = $this->dao->getData($query);

            return $result;
        } catch (Exception $e) {
            echo "Erro ao buscar pedidos da confeitaria: " . $e->getMessage();
            return [];
        }
    }

    public function addCarrinho()
    {
        try {
            $id = $_POST['id'];
            $sql = $this->dao->getData("SELECT * FROM tbproduto WHERE idProduto = $id");

            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = [];
            } else if (!empty($_SESSION['carrinho'])) {
                $confeitariaAtual = $_SESSION['carrinho'][0]['idConfeitaria'];
                if ($confeitariaAtual != $sql[0]['idConfeitaria']) {
                    return 'id_diferente';
                }
            }

            $produtoExistente = false;
            foreach ($_SESSION['carrinho'] as &$item) {
                if ($item['idProduto'] == $id) {
                    $item['quantidade'] += 1;
                    return 'add';
                    if ($item['quantidade'] > 5) {
                        $item['quantidade'] = 5; // Limita a quantidade máxima a 5
                    }
                    $produtoExistente = true;
                    break;
                }
            }

            if (!$produtoExistente) {
                $produto = [
                    'idProduto' => $sql[0]['idProduto'],
                    'nomeProduto' => $sql[0]['nomeProduto'],
                    'descProduto' => $sql[0]['descProduto'],
                    'imgProduto' => $sql[0]['imgProduto'],
                    'valorProduto' => $sql[0]['valorProduto'],
                    'frete' => $sql[0]['frete'],
                    'quantidade' => 1,
                    'idConfeitaria' => $sql[0]['idConfeitaria']
                ];
                $_SESSION['carrinho'][] = $produto;
                return 'add';
            } else {
                return 'no add';
            }

        } catch (Exception $e) {
            echo "Erro ao adicionar dados ao carrinho: " . $e->getMessage();
            return false;
        }
    }
}
?>