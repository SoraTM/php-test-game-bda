<?php

namespace game;

abstract class Cell
{
    private $name;
    private $bonus;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName($name)
    {
        return $this->name;
    }

    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    public function getBonus($bonus)
    {
        return $this->bonus;
    }

    public function action()
    {
    }
}
