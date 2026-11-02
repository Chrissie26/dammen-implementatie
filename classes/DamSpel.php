<?php

declare(strict_types=1);

class DamSpel
{
    private Bord $bord;
    private regelcontroleur $regelControleur;
    private userInterface $userInterface;
    private array $spelers = ['wit', 'zwart'];
    private array $score;
    private int $spelerAanDeBeurt; // Index van de speler


    public function __construct()
    {
        $this->bord = new Bord();
        $this->userInterface = new UserInterface();
        $this->regelControleur = new RegelControleur();
        $this->spelerAanDeBeurt = 0; // Wit begint
    }

    public function start(): void
    {
        echo "\nHet damspel is gestart!\n\n";
        echo "Geef je zetten op in het formaat: X,Y X,Y\n";
        echo "Bijvoorbeeld: 1,6 2,5\n\n";
        echo "Typ 'exit' om het spel te stoppen...\n\n";

        while (true) {
            // Print het dambord
            $this->bord->printStatus();

            // voor gemak:
            $huidigeSpeler = $this->spelers[$this->spelerAanDeBeurt];

            // Vraag om zet
            $zet = $this->userInterface->vraagSpelerOmZet($huidigeSpeler);

            if (!$this->regelControleur->isZetGeldig($zet, $this->bord, $huidigeSpeler)) {
                echo "Deze zet is niet geldig! Probeer het opnieuw.\n";
                continue;
            }

            // Wis de terminal alleen als de zet geldig is.
            // Doe je het eerder (voor het printen van het bord) dan zie je de foutmeldingen niet....
            echo "\033[2J\033[H";

            echo "De zet is geldig: ";
            echo strtoupper($huidigeSpeler) . " gaat";
            echo " van " . $zet->getVanPositie()->getX() . "," . $zet->getVanPositie()->getY();
            echo " naar " . $zet->getNaarPositie()->getX() . "," . $zet->getNaarPositie()->getY() . "\n\n";

            // voer de zet uit
            $this->bord->voerZetUit($zet, $huidigeSpeler, $this);

            $this->checkPromotie($this->bord->getSteenOpCoordinaten($zet->getNaarPositie()->getX(), $zet->getNaarPositie()->getY()), $zet->getNaarPositie());

            if ($this->isSpelAfgelopen()) {
                break;
            }

            // wissel de speler
            $this->spelerAanDeBeurt = 1 - $this->spelerAanDeBeurt; // Wisselt tussen 0 en 1
        }
    }

    private function checkPromotie(AbstractSteen $steen, Positie $positie): void
    {
        if ($steen->getKleur() === 'wit' && $positie->getY() === 0) {
            $this->promoveerNaarDam(new Dam($steen->getKleur()), $positie);
        }
        if ($steen->getKleur() === 'zwart' && $positie->getY() === 9) {
            $this->promoveerNaarDam(new Dam($steen->getKleur()), $positie);
        }
    }


    private function promoveerNaarDam(AbstractSteen $steen, Positie $positie): void
    {
        $this->bord->setSteenOpPositie($positie, $steen);
        echo get_class($this->bord->getSteenOpPositie($positie));
    }

    public function verhoogscore(string $speler): void
    {
        $this->score[$speler] = ($this->score[$speler] ?? 0) + 1;
        echo $speler . " heeft score erbij: " . $this->score[$speler];
    }

    private function getScore(): string
    {
        return "Score - Wit: " . ($this->score['wit'] ?? 0) . ", Zwart: " . ($this->score['zwart'] ?? 0);
    }

    private function isSpelAfgelopen(): bool
    {
        $aantalstenen = $this->bord->getBordBreedte() * 2;
        if (($this->score['wit'] ?? 0) >= $aantalstenen || ($this->score['zwart'] ?? 0) >= $aantalstenen) {
            echo "Het spel is afgelopen! " . $this->bepaalWinnaar() . "\n";
            echo $this->getScore() . "\n";
            return true;
        }
        return false;
    }

    private function bepaalWinnaar(): string
    {
        if ($this->score['wit'] > $this->score['zwart']) {
            return "Wit wint!";
        } elseif ($this->score['zwart'] > $this->score['wit']) {
            return "Zwart wint!";
        } else {
            return "Gelijkspel!";
        }
    }
}
