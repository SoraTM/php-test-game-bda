<?php

namespace game;

require(__DIR__ . '/vendor/autoload.php');

//getting previous game state
$gameState = new GameState();
$gameState->loadState();

//starting game, setting params from state
$game = new Game($gameState);
$game->setDiceScore();
print_r($game->getDiceScore());
$game->step();
$gameState->saveState();

/*
$cells[] = new Cell();

$game->setCells($cells);
$game->setStepScore();
$game->setTotalScore();
$game->setPosition();
$game->setDiceCount();


$player = new Player();
$player->set();
*/
