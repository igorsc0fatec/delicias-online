<?php

class Delete
{
    public function deletarTelCliente(): void
    {
        include_once '../controller/controller-cliente.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $clienteController = new ControllerCliente();
            $clienteController->deleteTelefone($id);
        }
    }

    public function deletarTelConfeitaria(): void
    {
        include_once '../controller/controller-confeitaria.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $confeitariaController = new ControllerConfeitaria();
            $confeitariaController->deleteTelefone($id);
        }
    }

    public function deletarEndereco(): void
    {
        include_once '../controller/controller-cliente.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $clienteController = new ControllerCliente();
            $clienteController->deleteEndereco($id);
        }
    }

    public function deletarRecheio()
    {
        include_once '../controller/controller-recheio.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $recheioController = new ControllerRecheio();
            $recheioController->deleteRecheio($id);
        }
    }

    public function deletarMassa()
    {
        include_once '../controller/controller-massa.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $massaController = new ControllerMassa();
            $massaController->deleteMassa($id);
        }
    }

    public function deletarFormato()
    {
        include_once '../controller/controller-formato.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $formatoController = new ControllerFormato();
            $formatoController->deleteFormato($id);
        }
    }

    public function deletarDecoracao()
    {
        include_once '../controller/controller-decoracao.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $decoracaoController = new ControllerDecoracao();
            $decoracaoController->deleteDecoracao($id);
        }
    }

    public function deletarCobertura()
    {
        include_once '../controller/controller-cobertura.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $coberturaController = new ControllerCobertura();
            $coberturaController->deleteCobertura($id);
        }
    }

    public function deletarPeso()
    {
        include_once '../controller/controller-peso.php';

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $coberturaController = new ControllerPeso();
            $coberturaController->deletePeso($id);
        }
    }
}
