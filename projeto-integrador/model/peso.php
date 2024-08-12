<?php
class Peso
{
    private float $peso;
    private int $id;
    private int $idTipoProduto;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
    public function getPeso(): float
    {
        return $this->peso;
    }

    public function setPeso(float $peso): void
    {
        $this->peso = $peso;
    }

    public function getIdTipoProduto(): int
    {
        return $this->idTipoProduto;
    }

    public function setIdTipoProduto(int $idTipoProduto): void
    {
        $this->idTipoProduto = $idTipoProduto;
    }
}

?>