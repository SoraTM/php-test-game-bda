<?php

namespace game;

class Cell
{
    private $name;
    private $bonus;
    private $destination;

    public function __construct($name, $bonus, $destination = null)
    {
        $this->setName($name);
        $this->setBonus($bonus);
        $this->setDestination($destination);
    }

    public function action()
    {
        return [
            'bonus' => $this->getBonus(),
            'destination' => $this->getDestination(),
        ];
    }

    private function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    private function setBonus($bonus)
    {
        $this->bonus = $bonus;
    }

    private function getBonus()
    {
        return $this->bonus;
    }

    private function setDestination($destination)
    {
        $this->destination = $destination;
    }

    private function getDestination()
    {
        return $this->destination;
    }
}
