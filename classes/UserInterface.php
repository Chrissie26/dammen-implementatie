<?php

declare(strict_types=1);

class UserInterface
{
    public function vraagSpelerOmZet(string $speler): Zet
    {
        while (true) {
            // geef aan wie er aan de beurt is
            echo strtoupper($speler) . " is aan de beurt. ";

            // vraag om invoer
            echo "Geef je zet op:\n";
            $invoer = trim(readline("> "));

            // Controleer of de speler wil stoppen
            if (strtolower($invoer) === 'exit') {
                echo "Het spel is gestopt. Tot ziens!\n\n";
                exit();
            }

            // Controleer of de invoer het juiste formaat heeft
            if (!preg_match('/^\d,\d \d,\d$/', $invoer)) {
                echo "Ongeldige invoer! Probeer het opnieuw...\n\n";
                continue; // Terug naar het begin van de loop 
            }

            // invoer OK, maak array aan voor start en eind deel
            [$start, $eind] = explode(' ', $invoer);

            // maak arrays aan met start - en eindcoordinaten
            [$startX, $startY] = explode(',', $start);
            [$eindX, $eindY]   = explode(',', $eind);

            // Maak Positie-objecten voor start en eind
            $vanPositie  = new Positie((int)$startX, (int)$startY);
            $naarPositie = new Positie((int)$eindX, (int)$eindY);

            // Retourneer een Zet-object
            return new Zet($vanPositie, $naarPositie);
        }
    }
}
