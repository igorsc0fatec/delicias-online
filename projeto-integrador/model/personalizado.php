<?php
class Personalizado
{
    private int $idPersonalizado;
    private string $nomePersonalizado;
    private string $descPersonalizado;
    private int $qtdPersonalizado;
    private bool $ativoPersonalizado;
    private float $idPeso;
    private int $idTipoProduto;

    public function getIdPersonalizado(): int
    {
        return $this->idPersonalizado;
    }

    public function setIdPersonalizado(int $idPersonalizado): void
    {
        $this->idPersonalizado = $idPersonalizado;
    }

    public function getNomePersonalizado(): string
    {
        return $this->nomePersonalizado;
    }

    public function setNomePersonalizado(string $nomePersonalizado): void
    {
        $this->nomePersonalizado = $nomePersonalizado;
    }

    public function getDescPersonalizado(): string
    {
        return $this->descPersonalizado;
    }

    public function setDescPersonalizado(string $descPersonalizado): void
    {
        $this->descPersonalizado = $descPersonalizado;
    }

    public function getQtdPersonalizado(): int
    {
        return $this->qtdPersonalizado;
    }

    public function setQtdPersonalizado(int $qtdPersonalizado): void
    {
        $this->qtdPersonalizado = $qtdPersonalizado;
    }

    public function getAtivoPersonalizado(): bool
    {
        return $this->ativoPersonalizado;
    }

    public function setAtivoPersonalizado(bool $ativoPersonalizado): void
    {
        $this->ativoPersonalizado = $ativoPersonalizado;
    }

    public function getIdPeso(): float
    {
        return $this->idPeso;
    }

    public function setIdPeso(float $idPeso): void
    {
        $this->idPeso = $idPeso;
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