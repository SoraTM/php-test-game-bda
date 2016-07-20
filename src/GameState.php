<?php

namespace game;

class GameState
{
    private $state = [];

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setStepScore($score)
    {
        $this->state['stepScore'] = $score;
    }

    public function getStepScore()
    {
        return $this->state['stepScore'];
    }

    public function setTotalScore($score)
    {
        $this->state['totalScore'] = $score;
    }

    public function getTotalScore()
    {
        return $this->state['totalScore'];
    }

    public function setPosition($position)
    {
        $this->state['position'] = $position;
    }

    public function getPosition()
    {
        return $this->state['position'];
    }

    public function setDiceCount($count)
    {
        $this->state['diceCount'] = $count;
    }

    public function getDiceCount()
    {
        return $this->state['diceCount'];
    }

    public function saveState()
    {
        setcookie("gameState[stepScore]", $this->state['stepScore'], time()+3600);
        setcookie("gameState[totalScore]", $this->state['totalScore'], time()+3600);
        setcookie("gameState[position]", $this->state['position'], time()+3600);
        setcookie("gameState[diceCount]", $this->state['diceCount'], time()+3600);
    }

    public function loadState()
    {
        if (isset($_COOKIE['gameState'])) {
            foreach ($_COOKIE['gameState'] as $name => $value) {
                $this->state[$name] = $value;
            }
        } else {
            $this->state['stepScore'] = 0;
            $this->state['totalScore'] = 0;
            $this->state['position'] = 0;
            $this->state['diceCount'] = 7;
            $this->saveState();
        }
    }
}
