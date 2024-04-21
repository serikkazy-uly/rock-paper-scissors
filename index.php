<?php
require_once "src/ArgumentParser.php";
require_once "src/Game.php";
require_once "src/HelpTableGenerator.php";
require_once "src/HmacCalculator.php";
require_once "src/KeyGenerator.php";

$argumentParser = new ArgumentParser($argv);
$moves = $argumentParser->getMoves();

if (count($moves) % 2 !== 1 || count($moves) < 3) {
    echo "Invalid number of moves. Please provide an odd number of unique moves (at least 3).\n";
    exit(1);
}

$hmacKey = KeyGenerator::generateKey();

$game = new Game($moves, $hmacKey);

echo "HMAC: " . HmacCalculator::calculateHmac($moves[0], $hmacKey) . "\n";

echo "Available moves:\n";
foreach ($moves as $index => $move) {
    echo $index + 1 . " - $move\n";
}
echo "0 - exit\n? - help\n";

$userMoveIndex = readline(
    "Enter your move (1-" . count($moves) . ") or '?' for help: "
);
if ($userMoveIndex === "?") {
    echo HelpTableGenerator::generateTable($moves) . "\n";
    exit(0);
}

if (
    !ctype_digit($userMoveIndex) ||
    $userMoveIndex < 1 ||
    $userMoveIndex > count($moves)
) {
    echo "Invalid input. Please enter a number between 1 and " .
        count($moves) .
        ".\n";
    exit(1);
}

$game->play();
