<?php

declare(strict_types=1);

class Zet
{
    private Positie $vanPositie;
    private Positie $naarPositie;

    public function __construct(Positie $vanPositie, Positie $naarPositie)
    {
        $this->vanPositie = $vanPositie;
        $this->naarPositie = $naarPositie;
    }

    public function getVanPositie(): Positie
    {
        return $this->vanPositie;
    }
    public function getNaarPositie(): Positie
    {
        return $this->naarPositie;
    }
}
