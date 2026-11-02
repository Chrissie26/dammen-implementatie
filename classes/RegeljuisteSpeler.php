<?php

class RegeljuisteSpeler implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $start = $zet->getVanPositie();
        $steen = $bord->getSteenOpCoordinaten($start->getX(), $start->getY());

        if ($steen->getKleur() !== $huidigeSpeler) {
            echo "Fout: Dit is niet jouw steen." . PHP_EOL;
            return false;
        }
        return true;
    }
}
