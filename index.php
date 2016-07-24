<?php

namespace game;

require(__DIR__ . '/vendor/autoload.php');

//getting previous game state
$gameState = new GameState();
$gameState->loadState();

//starting game, setting params from state
$game = new Game($gameState);

//adding cells to court
$game->addCell(new Cell('start', 5));
$game->addCell(new Cell('snow-house-0', 15));
$game->addCell(new Cell('snow-house-1', 15));
$game->addCell(new Cell('wigwam-0', 30));
$game->addCell(new Cell('wigwam-1', 30));
$game->addCell(new Cell('train-0', 10));
$game->addCell(new Cell('handcuffs-0', 0));
$game->addCell(new Cell('back-0', 0, 'handcuffs-0'));
$game->addCell(new Cell('house-0', 50));
$game->addCell(new Cell('house-1', 50));
$game->addCell(new Cell('glass-0', 0));
$game->addCell(new Cell('car-0', 20));
$game->addCell(new Cell('up-0', 0, 'wigwam-1'));
$game->addCell(new Cell('high-building-0', 80));
$game->addCell(new Cell('high-building-1', 80));
$game->addCell(new Cell('airplain-0', 30));
$game->addCell(new Cell('police-0', 0, 'handcuffs-0'));
$game->addCell(new Cell('custle-0', 120));
$game->addCell(new Cell('custle-1', 120));
$game->addCell(new Cell('theater-0', 200));

//checking dice Count
if (isset($_POST['diceScore'])) {
    $diceScore = $_POST['diceScore'];
    $game->setDiceScore($diceScore);
    $game->step();

    //saving result
    $gameState->saveState();
}

//used for getting pimpa steps, to animate on client
if (isset($_GET['stepsToNextPoint'])) {
    echo json_encode($game->getNextPositionRoute($_GET['stepsToNextPoint']));
    return;
}

//getting result and print it
$result = [
    'diceScore' => $game->getDiceScore(),
    'stepScore' => $game->getStepScore(),
    'totalScore' => $game->getTotalScore(),
    'position' => $game->getPositionName($game->getPosition()),
    'diceCount' => $game->getDiceCount(),
];

$renderer = new Renderer('index', $result);

echo $renderer->render();
