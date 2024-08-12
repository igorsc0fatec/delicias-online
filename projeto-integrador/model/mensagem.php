<?php
class Mensagem
{
    private int $idMensagem;
    private String $mensagem;
    private String $horaEnvio;
    private int $idRemetente;
    private int $idDestinatario;

    public function getIdMensagem(): int
    {
        return $this->idMensagem;
    }

    public function setIdMensagem(int $idMensagem): void
    {
        $this->idMensagem = $idMensagem;
    }

    public function getMensagem(): String
    {
        return $this->mensagem;
    }

    public function setMensagem(String $mensagem): void
    {
        $this->mensagem = $mensagem;
    }

    public function getHoraEnvio(): String
    {
        return $this->horaEnvio;
    }

    public function setHoraEnvio(String $horaEnvio): void
    {
        $this->horaEnvio = $horaEnvio;
    }

    public function getIdRemetente(): int
    {
        return $this->idRemetente;
    }

    public function setIdRemetente(int $idRemetente): void
    {
        $this->idRemetente = $idRemetente;
    }

    public function getIdDestinatario(): int
    {
        return $this->idDestinatario;
    }

    public function setIdDestinatario(int $idDestinatario): void
    {
        $this->idDestinatario = $idDestinatario;
    }
}
?>