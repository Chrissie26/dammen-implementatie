<?php

interface RegelInterface
{
    public function check(Zet $zet, Bord $bord, string $huidigeSpeler): bool;
}
