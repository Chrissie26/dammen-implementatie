<?php

class RegelEindPositieLeeg implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $huidigeSpeler = $huidigeSpeler;
        $eind = $zet->getNaarPositie();

        $eindVak = $bord->getVakje($eind->getX(), $eind->getY());

        if ($eindVak->getSteen() !== null) {
            echo "Fout: De eindpositie is niet leeg." . PHP_EOL;
            return false;
        }
        return true;
    }
}
