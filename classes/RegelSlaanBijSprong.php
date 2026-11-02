<?php

class RegelSlaanBijSprong implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $start = $zet->getVanPositie();
        $eind = $zet->getNaarPositie();

        $dx = abs($eind->getX() - $start->getX());

        if ($dx === 2) {
            $tussenX = ($start->getX() + $eind->getX()) / 2;
            $tussenY = ($start->getY() + $eind->getY()) / 2;
            $tussenVak = $bord->getVakje($tussenX, $tussenY);

            if ($tussenVak->getSteen() === null || $tussenVak->getSteen()->getKleur() === $huidigeSpeler) {
                echo "Fout: Bij een sprong van 2 moet je een vijandelijke steen slaan." . PHP_EOL;
                return false;
            }
        }
        return true;
    }
}
