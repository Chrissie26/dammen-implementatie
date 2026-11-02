<?php

class Bord
{
    private array $vakjes = [];
    private $BORD_BREEDTE = 10;
    private $BORD_HOOGTE = 10;

    public function __construct()
    {
        // Bord initialiseren
        for ($rij = 0; $rij < 10; $rij++) {
            $this->vakjes[$rij] = [];
            for ($kolom = 0; $kolom < 10; $kolom++) {
                // Afwisselend zwart/wit vakje
                $kleur = ($rij + $kolom) % 2 == 0 ? "zwart" : "wit";

                // Beginposities van de stenen
                if ($rij < 4 && $kleur === "zwart") {
                    $steen = new Steen("zwart"); // Zwarte stenen bovenaan
                } elseif ($rij > 5 && $kleur === "zwart") {
                    $steen = new Steen("wit"); // Witte stenen onderaan
                } else {
                    $steen = null;
                }

                $this->vakjes[$rij][$kolom] = new Vak($kleur, $steen);
            }
        }
    }

    public function getVakjes(): array
    {
        return $this->vakjes;
    }

    public function getVakje(int $x, int $y): ?Vak
    {
        return $this->vakjes[$y][$x];
    }

    public function setVakje(int $x, int $y, Vak $vak): void
    {
        $this->vakjes[$y][$x] = $vak;
    }

    public function getSteenOpPositie(Positie $positie): ?AbstractSteen
    {
        $vak = $this->getVakje($positie->getX(), $positie->getY());
        return $vak->getSteen();
    }

    public function setSteenOpPositie(Positie $positie, ?AbstractSteen $steen): void
    {
        $vak = $this->getVakje($positie->getX(), $positie->getY());
        $vak->setSteen($steen);
    }

    public function getSteenOpCoordinaten(int $x, int $y): ?AbstractSteen
    {
        $vak = $this->getVakje($x, $y);
        return $vak->getSteen();
    }

    public function printStatus(): void
    {
        echo PHP_EOL;

        echo "  Y↓\n";

        // Print bovenkant bord
        echo "    ╔═══╤═══╤═══╤═══╤═══╤═══╤═══╤═══╤═══╤═══╗\n";

        // Print elke rij van het bord
        foreach ($this->vakjes as $rijIndex => $rij) {
            // Rijnummer (Y-as coördinaat)
            echo "  $rijIndex ║";

            // Print de vakken in de rij
            foreach ($rij as $kolomIndex => $vak) {
                if ($vak->getSteen() !== null) {
                    if ($vak->getSteen() instanceof Steen) {
                        // Toon steen (W voor wit, Z voor zwart)
                        echo " " . substr(strtoupper($vak->getSteen()->getKleur()), 0, 1) . " ";
                    } else if ($vak->getSteen() instanceof Dam) {
                        echo " " . substr($vak->getSteen()->getKleur(), 0, 1) . " ";
                    }
                } else {
                    // Leeg vak
                    echo "   ";
                }

                // Afsluiten met een separator
                if ($kolomIndex < 9) {
                    echo "│"; // Tussen  de vakken
                } else {
                    echo "║"; // Voor het laatste vak in de rij
                }
            }

            // Sluit de rij af
            echo PHP_EOL;

            if ($rijIndex < 9) {
                // Print tussenliggende randen
                echo "    ╟───┼───┼───┼───┼───┼───┼───┼───┼───┼───╢\n";
            } else {
                // Print onderkant
                echo "    ╚═══╧═══╧═══╧═══╧═══╧═══╧═══╧═══╧═══╧═══╝\n";
            }
        }

        // Print X-as coördinaten
        echo "  X→  0   1   2   3   4   5   6   7   8   9 \n";

        echo PHP_EOL;
    }

    public function voerZetUit(Zet $zet, string $speler, DamSpel $damspel): void
    {
        $start = $zet->getVanPositie();
        $eind = $zet->getNaarPositie();

        // Verplaats de steen
        $this->setSteenOpPositie($eind, $this->getSteenOpPositie($start));
        $this->setSteenOpPositie($start, null);

        // Controleer of er een steen is geslagen
        $dx = abs($eind->getX() - $start->getX());
        $dy = abs($eind->getY() - $start->getY());

        if ($dx === 2 && $dy === 2) { // Bij een sprong van 2
            $tussenX = ($start->getX() + $eind->getX()) / 2;
            $tussenY = ($start->getY() + $eind->getY()) / 2;
            $tussenvakje = new Positie($tussenX, $tussenY);

            // Verwijder de geslagen steen
            $this->setSteenOpPositie($tussenvakje, null);
            $damspel->verhoogscore($speler);
        }
    }

    public function getBordBreedte(): int
    {
        return $this->BORD_BREEDTE;
    }

    public function getBordHoogte(): int
    {
        return $this->BORD_HOOGTE;
    }
}
