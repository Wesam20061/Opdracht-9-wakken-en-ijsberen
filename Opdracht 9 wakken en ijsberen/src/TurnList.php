<?php
class TurnList {
    private array $turns = [];

    public function addTurn(Turn $turn): void {
        $this->turns[] = $turn;
    }

    public function getCurrentTurn(): Turn {
        return end($this->turns);
    }

    public function getAmountTurns(): int {
        return count($this->turns);
    }
}
