<?php


class Game
{
    private $moves;
    private $hmacKey;

    public function __construct($moves, $hmacKey)
    {
        $this->moves = $moves;
        $this->hmacKey = $hmacKey;
    }

    public function startGame()
    {
        echo "HMAC: " . HmacCalculator::calculateHmac($this->moves[0], $this->hmacKey) . "\n";
        echo "Available moves:\n";
        foreach ($this->moves as $index => $move) {
            echo ($index + 1) . " - $move\n";
        }
        echo "0 - exit\n? - help\n";
    }

    public function userMove()
    {
    }

    public function getResult($userMove, $compMove)
    {
    }
}
