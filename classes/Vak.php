<?php

declare(strict_types=1);

class Vak
{
    private string $kleur;
    private ?AbstractSteen $steen;

    public function __construct(string $kleur, ?Steen $steen = null)
    {
        $this->kleur = $kleur;
        $this->steen = $steen;
    }

    public function getKleur(): string
    {
        return $this->kleur;
    }

    public function getSteen(): ?AbstractSteen
    {
        return $this->steen;
    }

    public function setSteen(?abstractSteen $steen): void
    {
        $this->steen = $steen;
    }

    public function isLeeg(): bool
    {
        if (isset($this->steen)) {
            return false;
        } else {
            return true;
        }
    }
}
