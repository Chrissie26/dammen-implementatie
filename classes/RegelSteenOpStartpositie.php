<?php

class RegelSteenOpStartpositie implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $huidigeSpeler = $huidigeSpeler;
        $start = $zet->getVanPositie();
        $startVak = $bord->getVakje($start->getX(), $start->getY());

        if ($startVak->getSteen() === null) {
            echo "Fout: Er staat geen steen op de startpositie." . PHP_EOL;
            return false;
        }
        return true;
    }
}
