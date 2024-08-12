<?php
class Decoracao
{
    private string $descDecoracao;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescDecoracao(): string
    {
        return $this->descDecoracao;
    }

    public function setDescDecoracao(string $descDecoracao): void
    {
        $this->descDecoracao = $descDecoracao;
    }
}

?>