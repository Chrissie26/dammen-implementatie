<?php

declare(strict_types=1);

class Steen extends AbstractSteen
{
    private string $kleur;

    public function __construct(string $kleur)
    {
        $this->kleur = $kleur;
    }

    public function getKleur(): string
    {
        return $this->kleur;
    }

    public function kanAchteruitSlaan(): bool
    {
        return false;
    }
}
