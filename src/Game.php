<?php
require_once "KeyGenerator.php";
require_once "HmacCalculator.php";
require_once "HelpTableGenerator.php";
require_once "ArgumentParser.php";

class Game
{
    private $moves;
    private $hmacKey;
    private $computerMoveHmac;

    public function __construct($moves, $hmacKey)
    {
        $this->moves = $moves;
        $this->hmacKey = $hmacKey;
    }

    public function start()
    {
        if (count($this->moves) % 2 === 0) {
            echo "Invalid number of moves. Please provide an odd number of unique moves (at least 3).\n";
            exit(1);
        }

        $this->computerMoveHmac = $this->generateComputerMoveHmac();

        echo "Secret key: {$this->hmacKey}\n";
        echo "HMAC: {$this->computerMoveHmac}\n";

        echo "Available moves:\n";
        foreach ($this->moves as $index => $move) {
            echo $index + 1 . " - $move\n";
        }
        echo "0 - exit\n? - help\n";

        $this->play();
    }

    private function generateComputerMoveHmac()
    {
        $compMove = $this->moves[array_rand($this->moves)];
        return HmacCalculator::calculateHmac($compMove, $this->hmacKey);
    }

    private function getUserMove()
    {
        do {
            echo "Enter your move (1 - Rock, 2 - Paper, 3 - Scissors): ";
            $input = readline();
            if ($input === "0") {
                exit();
            } elseif ($input === "?") {
                echo HelpTableGenerator::generateTable($this->moves) . "\n";
                continue;
            }

            if (!is_numeric($input)) {
                echo "Invalid input. Please enter a number.\n";
                continue;
            }

            $moveIndex = intval($input) - 1;
        } while (
            !is_numeric($input) ||
            $moveIndex < 0 ||
            $moveIndex >= count($this->moves)
        );

        return $this->moves[$moveIndex];
    }

    public function play()
    {
        $userMove = $this->getUserMove();

        if ($userMove === "0") {
            exit();
        }

        $compMove = $this->moves[array_rand($this->moves)];
        $this->computerMoveHmac = $this->generateComputerMoveHmac();

        $result = $this->getResult($userMove, $compMove);

        echo "Your move: $userMove\n";
        echo "Computer move: $compMove\n";
        echo "$result\n";

        echo "Computed HMAC: {$this->computerMoveHmac}\n";
        echo "Enter your move (1 - Rock, 2 - Paper, 3 - Scissors): ";
        $this->play();
    }

    public function getResult($userMove, $compMove)
    {
        if ($userMove === $compMove) {
            return "Draw";
        } elseif (
            ($userMove === "rock" && $compMove === "scissors") ||
            ($userMove === "scissors" && $compMove === "paper") ||
            ($userMove === "paper" && $compMove === "rock")
        ) {
            return "You win!";
        } else {
            return "Computer wins!";
        }
    }
}

$argumentParser = new ArgumentParser($argv);
$moves = $argumentParser->getMoves();
$hmacKey = KeyGenerator::generateKey();

$game = new Game($moves, $hmacKey);
$game->start();
