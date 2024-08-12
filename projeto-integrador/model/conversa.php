<?php
class Conversa
{
    private string $lido;
    private String $modificado;
    private String $dataCriacao;
    private int $idPrincipal;
    private int $idOutro;

    public function getLido(): string
    {
        return $this->lido;
    }

    public function setLido(string $lido): void
    {
        $this->lido = $lido;
    }

    public function getModificado(): String
    {
        return $this->modificado;
    }

    public function setModificado(String $modificado): void
    {
        $this->modificado = $modificado;
    }

    public function getDataCriacao(): String
    {
        return $this->dataCriacao;
    }

    public function setDataCriacao(String $dataCriacao): void
    {
        $this->dataCriacao = $dataCriacao;
    }

    public function getIdPrincipal(): int
    {
        return $this->idPrincipal;
    }

    public function setIdPrincipal(int $idPrincipal): void
    {
        $this->idPrincipal = $idPrincipal;
    }

    public function getIdOutro(): int
    {
        return $this->idOutro;
    }

    public function setIdOutro(int $idOutro): void
    {
        $this->idOutro = $idOutro;
    }
}
?>