<?php

require_once 'ArgumentParser.php';
require_once 'Game.php';
require_once 'HmacCalculator.php';
require_once 'KeyGenerator.php';

$arguments = $_SERVER['argv'];

$argumentParser = new ArgumentParser($arguments);

$moves = $argumentParser->getMoves();

$hmacKey = KeyGenerator::generateKey();

$game = new Game($moves, $hmacKey);

$game->startGame();
