<?php

declare(strict_types=1);

class RegelControleur
{
    private array $regels;

    public function __construct()
    {
        $this->regels = [
            new RegelSteenOpStartpositie(),
            new RegelDiagonaleZet(),
            new RegelEindPositieLeeg(),
            new RegeljuisteSpeler(),
            new RegelSlaanBijSprong(),
            new RegelSlaanVerplicht(),
            new RegelSteenBeweegtVooruit()
        ];
    }

    public function isZetGeldig(Zet $zet, Bord $bord, string $speler): bool
    {
        foreach ($this->regels as $regel) {
            if (!$regel->check($zet, $bord, $speler) == true) {
                return false;
            }
        }
        return true;
    }
}
