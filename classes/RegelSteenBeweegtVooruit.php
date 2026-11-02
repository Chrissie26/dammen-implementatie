<?php

class RegelSteenBeweegtVooruit implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $start = $zet->getVanPositie();
        $eind = $zet->getNaarPositie();

        if ($bord->getSteenOpCoordinaten($start->getX(), $start->getY()) instanceof Dam) {
            return true;
        }

        if ($huidigeSpeler === 'wit' && $eind->getY() >= $start->getY()) {
            echo "Fout: Witte stenen mogen alleen omhoog bewegen." . PHP_EOL;
            return false;
        }
        if ($huidigeSpeler === 'zwart' && $eind->getY() <= $start->getY()) {
            echo "Fout: Zwarte stenen mogen alleen omlaag bewegen." . PHP_EOL;
            return false;
        }
        return true;
    }
}
