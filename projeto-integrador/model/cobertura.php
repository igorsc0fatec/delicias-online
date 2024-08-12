<?php
class Cobertura
{
    private string $descCobertura;
    private int $id;

    public function getDescCobertura(): string
    {
        return $this->descCobertura;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setDescCobertura(string $descCobertura): void
    {
        $this->descCobertura = $descCobertura;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}

?>