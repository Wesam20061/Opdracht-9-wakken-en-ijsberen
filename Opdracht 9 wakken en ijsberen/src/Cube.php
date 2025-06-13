<?php
class Cube
{
    private int $dice; // dobbelsteenwaarde
    private int $iceHoles = 0;
    private int $polarBears = 0;
    private int $penguins = 0;

    public function dice()
    {
        $this->dice = rand(1, 6);

        // Bereken wakken, ijsberen en pinguïns
        if (in_array($this->dice, [1, 3, 5])) {
            $this->iceHoles = 1;
            $this->polarBears = $this->dice - 1;
            $this->penguins = 7 - $this->dice;
        } else {
            $this->iceHoles = 0;
            $this->polarBears = 0;
            $this->penguins = 0;
        }
    }

    public function getDice(): int
    {
        return $this->dice;
    }

    public function getIceHoles(): int
    {
        return $this->iceHoles;
    }

    public function getPolarBears(): int
    {
        return $this->polarBears;
    }

    public function getPenguins(): int
    {
        return $this->penguins;
    }

    public function draw(): string
    {
        $draw = "<svg width='180' height='180'>
            <rect x='20' y='20' rx='20' ry='20' width='150' height='150'
                  style='fill:lightblue;stroke:black;stroke-width:5;opacity:1' />";

        // Middenstip (wak)
        if (in_array($this->dice, [1, 3, 5])) {
            $draw .= "<circle cx='95' cy='95' r='10' fill='blue' />";
        }

        // Linksboven & rechtsonder (waarde 4, 5, 6)
        if (in_array($this->dice, [4, 5, 6])) {
            $draw .= "<circle cx='55' cy='55' r='10' fill='white' />
                      <circle cx='135' cy='135' r='10' fill='white' />";
        }

        // Links-midden & rechts-midden (alleen 6)
        if ($this->dice === 6) {
            $draw .= "<circle cx='55' cy='95' r='10' fill='white' />
                      <circle cx='135' cy='95' r='10' fill='white' />";
        }

        // Linksonder & rechtsboven (waarde 2 t/m 6)
        if ($this->dice >= 2) {
            $draw .= "<circle cx='135' cy='55' r='10' fill='white' />
                      <circle cx='55' cy='135' r='10' fill='white' />";
        }

        $draw .= "</svg>";
        return $draw;
    }
}
