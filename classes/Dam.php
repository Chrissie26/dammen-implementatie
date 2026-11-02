<?php

class Dam extends AbstractSteen
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
        return true;
    }
}
