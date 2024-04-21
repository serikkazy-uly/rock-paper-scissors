<?php


// Game.php

class Game {
    private $moves;
    private $hmacKey;

    public function __construct($moves, $hmacKey) {
        $this->moves = $moves;
        $this->hmacKey = $hmacKey;
    }

    public function startGame() {
    }

    public function userMove() {
    }

    public function getResult($userMove, $compMove) {
    }
}
