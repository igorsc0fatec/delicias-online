<?php
class Formato
{
    private string $descFormato;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescFormato(): string
    {
        return $this->descFormato;
    }

    public function setDescFormato(string $descFormato): void
    {
        $this->descFormato = $descFormato;
    }
}

?>