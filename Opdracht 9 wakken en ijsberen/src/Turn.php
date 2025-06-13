<?php
class Turn
{
    private int $guessIceHoles;
    private int $guessPolarBears;
    private int $guessPenguins;

    public function __construct(int $iceHoles, int $polarBears, int $penguins)
    {
        $this->guessIceHoles = $iceHoles;
        $this->guessPolarBears = $polarBears;
        $this->guessPenguins = $penguins;

        if (!isset($_SESSION['turn'])) {
            $_SESSION['turn'] = 0;
        }

        $_SESSION['turn']++;
    }

    public function getGuessIceHoles(): int
    {
        return $this->guessIceHoles;
    }

    public function getGuessPolarBears(): int
    {
        return $this->guessPolarBears;
    }

    public function getGuessPenguins(): int
    {
        return $this->guessPenguins;
    }
}
