<?php
require_once "KeyGenerator.php";
require_once "HmacCalculator.php";
require_once "HelpTableGenerator.php";
require_once "ArgumentParser.php";

class Game
{
    private $moves;
    private $hmacKey;

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
        $hmac = HmacCalculator::calculateHmac($this->moves[0], $this->hmacKey);

        echo "HMAC: $hmac\n";

        echo "Available moves:\n";
        foreach ($this->moves as $index => $move) {
            echo $index + 1 . " - $move\n";
        }
        echo "0 - exit\n? - help\n";

        $this->play();
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
        $compMove = $this->moves[array_rand($this->moves)];
        echo "Computer move: $compMove\n";

        $prevHmac = HmacCalculator::calculateHmac($compMove, $this->hmacKey);

        $userMove = $this->getUserMove();

        if ($userMove === "0") {
            exit();
        }

        $newHmac = HmacCalculator::calculateHmac($userMove, $this->hmacKey);

        if ($prevHmac !== $newHmac) {
            echo "Error: Computer's move changed after your move!\n";
            exit(1);
        }

        $result = $this->getResult($userMove, $compMove);
        echo "Your move: $userMove\n";
        echo "$result\n";

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
