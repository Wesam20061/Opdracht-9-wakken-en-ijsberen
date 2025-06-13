<?php
class GameList {
    private array $games = [];

    public function addGame(Game $game): void {
        $this->games[] = $game;
        $_SESSION['game'] = $game;
    }

    public function getCurrentGame(): Game {
        return end($this->games);
    }

    public function getGames(): array {
        return $this->games;
    }
}
