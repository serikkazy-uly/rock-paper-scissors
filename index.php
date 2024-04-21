<?php
require_once 'ArgumentParser.php';

$arguments = $_SERVER['argv'];

$argumentParser = new ArgumentParser($arguments);

$moves = $argumentParser->getMoves();

echo "Moves: " . implode(", ", $moves) . "\n";
