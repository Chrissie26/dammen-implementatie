<?php

class RegelSlaanVerplicht implements RegelInterface
{
    #[Override]
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $start = $zet->getVanPositie();
        $eind = $zet->getNaarPositie();

        $dx = abs($eind->getX() - $start->getX());

        if ($dx === 2) {        // Er is al een slagzet gedaan
            return true;
        }
        $breedte = $bord->getBordBreedte();
        $hoogte = $bord->getBordHoogte();

        for ($x = 0; $x < $breedte; $x++) {
            for ($y = 0; $y < $hoogte; $y++) {
                $stone = $bord->getVakje($x, $y)->getSteen();
                if ($stone !== null && $stone->getKleur() === $huidigeSpeler) {
                    $huidigePositie = new Positie($x, $y);
                    if ($bord->getSteenOpCoordinaten($x, $y) instanceof Dam) {
                        $mogelijkeZetten = [
                            new Zet($huidigePositie, new Positie($x + 2, $y + 2)),
                            new Zet($huidigePositie, new Positie($x - 2, $y + 2)),
                            new Zet($huidigePositie, new Positie($x + 2, $y - 2)),
                            new Zet($huidigePositie, new Positie($x - 2, $y - 2))
                        ];
                    } else {
                        if ($huidigeSpeler === 'wit') {
                            $mogelijkeZetten = [
                                new Zet($huidigePositie, new Positie($x + 2, $y - 2)),
                                new Zet($huidigePositie, new Positie($x - 2, $y - 2))
                            ];
                        } else {
                            $mogelijkeZetten = [
                                new Zet($huidigePositie, new Positie($x + 2, $y + 2)),
                                new Zet($huidigePositie, new Positie($x - 2, $y + 2))
                            ];
                        }
                    }

                    foreach ($mogelijkeZetten as $mogelijkeZet) {
                        if ($this->isSlaanMogelijk($mogelijkeZet, $bord, $huidigeSpeler)) {
                            echo "Fout: Je moet een steen slaan als dat mogelijk is." . PHP_EOL;
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    public function isSlaanMogelijk(Zet $zet, Bord $bord, string $huidigeSpeler): bool
    {
        $start = $zet->getVanPositie();
        $eind = $zet->getNaarPositie();

        if ($eind->getX() < 0 || $eind->getX() >= $bord->getBordBreedte() || $eind->getY() < 0 || $eind->getY() >= $bord->getBordHoogte()) {
            return false;
        }

        $tussenX = ($start->getX() + $eind->getX()) / 2;
        $tussenY = ($start->getY() + $eind->getY()) / 2;
        $tussenVak = $bord->getVakje($tussenX, $tussenY)->getSteen();

        return ($tussenVak !== null && $tussenVak->getKleur() !== $huidigeSpeler && $bord->getVakje($eind->getX(), $eind->getY())->getSteen() === null);
    }
}
