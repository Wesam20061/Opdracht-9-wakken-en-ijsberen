<?php
class Play
{
    private string $name = '';
    private GameList $gameList;
    private HintList $hintList;

    public function __construct()
    {
        $this->gameList = new GameList();
        $_SESSION['correct'] = 0;
        $this->hintList = new HintList();
        $this->setHints();
    }

    public function reset(): void
    {
        foreach (['turn', 'play', 'game', 'status', 'wrong'] as $key) {
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
            }
        }
    }

    private function setHints(): void
    {
        $hints = [
            'Wakken bevinden zich in het midden van de dobbelsteen.',
            'IJsberen verschijnen alleen rondom wakken.',
            'Alleen bij worpen 1, 3 en 5 zijn er wakken.',
            'Pinguïns leven op de zuidpoolzijde van een wak.',
            'De som van tegenoverliggende zijden van een dobbelsteen is altijd 7.'
        ];

        foreach ($hints as $text) {
            $this->hintList->addHint(new Hint($text));
        }
    }

    public function setPlayerName(string $name): void
    {
        $this->name = $name;
    }

    public function getPlayerName(): string
    {
        return $this->name;
    }

    // ✅ aangepaste methode: accepteert Game-object
    public function addGame(Game $game): void
    {
        $this->gameList->addGame($game);
    }

    public function addGuess(int $iceHoles, int $polarBears, int $penguins)
    {
        return $this->gameList->getCurrentGame()->addGuess($iceHoles, $polarBears, $penguins);
    }

    public function checkScore(): string
    {
        return $this->gameList->getCurrentGame()->checkGuess();
    }

    public function draw(): void
    {
        $this->gameList->getCurrentGame()->drawCubes();
    }

    public function getHint(): string
    {
        return $this->hintList->getRandomHint()->getHintString();
    }

    public function getPreviousGames(): array
    {
        $games = $this->gameList->getGames();
        return array_slice($games, 0, count($games) - 1);
    }

    public function getAnswer(): array
    {
        return $this->gameList->getCurrentGame()->getAnswer();
    }

    public function getScore(): int
    {
        $score = 0;
        foreach ($this->gameList->getGames() as $game) {
            $score += $game->getScore();
        }
        return $score;
    }
}
