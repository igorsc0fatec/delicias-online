<?php
class Recheio
{
    private string $descRecheio;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescRecheio(): string
    {
        return $this->descRecheio;
    }

    public function setDescRecheio(string $descRecheio): void
    {
        $this->descRecheio = $descRecheio;
    }
}

?>