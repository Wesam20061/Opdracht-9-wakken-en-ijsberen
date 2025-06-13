<?php
class Game
{
    private int $wrong = 0;
    private int $correct = 0;
    private TurnList $turnList;
    private CubeList $cubeList;
    private int $resultIceHoles = 0;
    private int $resultPolarBears = 0;
    private int $resultPenguins = 0;

    public function __construct($amount)
    {
        $_SESSION['status'] = 'start';
        $this->cubeList = new CubeList();

        for ($i = 0; $i < $amount; $i++) {
            $cube = new Cube();
            $cube->dice();
            $this->cubeList->addCube($cube);
        }

        $this->result();
        $this->turnList = new TurnList();
        $_SESSION['turn'] = 0;
        $_SESSION['wrong'] = 0;
    }

    // Dobbelstenen tekenen
    public function drawCubes()
    {
        foreach ($this->cubeList->getCubes() as $cube) {
            echo $cube->draw();
        }
    }

    // Resultaat berekenen op basis van alle cubes
    private function result()
    {
        foreach ($this->cubeList->getCubes() as $cube) {
            $this->resultIceHoles += $cube->getIceHoles();
            $this->resultPolarBears += $cube->getPolarBears();
            $this->resultPenguins += $cube->getPenguins();
        }
    }

    public function getTurnList(): TurnList
    {
        return $this->turnList;
    }

    public function addGuess($iceHoles, $polarBears, $penguins)
    {
        $turn = new Turn($iceHoles, $polarBears, $penguins);
        $this->turnList->addTurn($turn);
        return $this->turnList->getCurrentTurn();
    }

    public function checkGuess(): string
    {
        $turn = $this->turnList->getCurrentTurn();

        if (
            $turn->getGuessIceHoles() === $this->resultIceHoles &&
            $turn->getGuessPolarBears() === $this->resultPolarBears &&
            $turn->getGuessPenguins() === $this->resultPenguins
        ) {
            $_SESSION['status'] = 'correct';
            $_SESSION['correct']++;
            $this->correct++;
            return 'correct geraden';
        } else {
            $_SESSION['status'] = 'wrong';
            $_SESSION['wrong']++;
            $this->wrong++;
            return 'helaas fout';
        }
    }

    public function getGameTurns(): int
    {
        return $this->turnList->getAmountTurns();
    }

    public function getWrongAnswers(): int
    {
        return $this->wrong;
    }

    public function getAnswer(): array
    {
        $_SESSION['status'] = 'answer';
        return [
            $this->resultIceHoles,
            $this->resultPolarBears,
            $this->resultPenguins
        ];
    }

    public function getScore(): int
    {
        return $this->correct;
    }
}
