<?php
class Massa
{
    private string $descMassa;
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getDescMassa(): string
    {
        return $this->descMassa;
    }

    public function setDescMassa(string $descMassa): void
    {
        $this->descMassa = $descMassa;
    }
}

?>