<?php

namespace game;

class Game
{
    private $diceScore;
    private $state;
    private $stepScore;
    private $totalScore;
    private $position;
    private $diceCount;
    private $cells = [];

    public function __construct($state)
    {
        $this->state = $state;
        $this->loadState();
    }

    public function step()
    {
        $nextPosition = $this->getNextPosition($this->getPosition(), $this->getDiceScore());
        $this->setPosition($nextPosition);
        $this->decreaseDiceCount();
        $this->cellAction();
        $this->saveState();
    }

    public function addCell(Cell $cell)
    {
        $this->cells[] = $cell;
    }

    private function cellAction()
    {
        $cellResult = $this->cells[$this->getPosition()]->action();
        $this->applyBonus($cellResult['bonus']);
        if (isset($cellResult['destination'])) {
            $this->setPosition($this->getPositionByName($cellResult['destination']));
        }
    }

    private function applyBonus($bonus)
    {
        if ($bonus > 0) {
            $this->setTotalScore($this->getTotalScore() + $bonus);
        }
        $this->setStepScore($bonus);
    }

    private function getPositionByName($name)
    {
        $arrFiltered = array_filter($this->cells, function ($item) use ($name) {
            return $item->getName() == $name;
        });
        return key($arrFiltered);
    }

    private function loadState()
    {
        $this->position = $this->state->getPosition();
        $this->diceScore = $this->state->getDiceScore();
        $this->stepScore = $this->state->getStepScore();
        $this->totalScore = $this->state->getTotalScore();
        $this->diceCount = $this->state->getDiceCount();
    }

    private function saveState()
    {
        $this->state->setPosition($this->getPosition());
        $this->state->setDiceScore($this->getDiceScore());
        $this->state->setStepScore($this->getStepScore());
        $this->state->setTotalScore($this->getTotalScore());
        $this->state->setDiceCount($this->getDiceCount());
    }

    public function getNextPosition($currentPosition, $stepsCount)
    {
        $currentPosition = $currentPosition;
        $nextPosition = $currentPosition + $stepsCount;
        if ($nextPosition > sizeof($this->cells) - 1) {
            $nextPosition = $nextPosition - sizeof($this->cells);
        }
        return $nextPosition;
    }

    public function getNextPositionRoute($stepsToNextPoint)
    {
        $routeStart = $this->getPosition();
        $routeLength = $stepsToNextPoint;
        $route = [];

        for ($i = 0; $i < $routeLength; $i++) {
            $nextPosition = $this->getNextPosition($routeStart, 1);
            $route[] = $this->getPositionName($nextPosition);
            $routeStart = $nextPosition;
        }
        return $route;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setDiceScore($score)
    {
        $this->diceScore = $score;
    }

    public function getDiceScore()
    {
        return $this->diceScore;
    }

    public function getPositionName($position)
    {
        return $this->cells[$position]->getName();
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setStepScore($score)
    {
        $this->stepScore = $score;
    }

    public function getStepScore()
    {
        return $this->stepScore;
    }

    public function setTotalScore($score)
    {
        $this->totalScore = $score;
    }

    public function getTotalScore()
    {
        return $this->totalScore;
    }

    public function setDiceCount($diceCount)
    {
        $this->diceCount = $diceCount;
    }

    public function getDiceCount()
    {
        return $this->diceCount;
    }

    private function decreaseDiceCount()
    {
        $this->setDiceCount($this->getDiceCount() - 1);
    }
}
