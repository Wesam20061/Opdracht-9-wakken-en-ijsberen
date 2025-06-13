<?php
class HintList {
    private array $hints = [];

    public function addHint(Hint $hint): void {
        $this->hints[] = $hint;
    }

    public function getRandomHint(): Hint {
        return $this->hints[array_rand($this->hints)];
    }
}
