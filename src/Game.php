<?php

namespace game;

class Game
{
    private $diceScore;
    private $cells;
    private $state;
    /*
    private $stepScore;
    private $totalScore;
    private $position;
    private $diceCount;
*/

    public function __construct($state)
    {
        $this->state = $state;
    }

    public function step()
    {
        $this->decreaseDiceCount();
    }

    public function getState()
    {
        return $this->state;
    }

    public function setDiceScore()
    {
        $this->diceScore = rand(1, 6);
    }

    public function getDiceScore()
    {
        return $this->diceScore;
    }

    private function decreaseDiceCount()
    {
        $diceCount = $this->state->getDiceCount();
        $this->state->setDiceCount(--$diceCount);
    }

    private function setPosition()
    {
    }
}
