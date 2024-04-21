<?php

class ArgumentParser {
    private $moves;

    public function __construct($args) {
        if (count($args) < 4) {
            echo "Invalid number of arguments. Usage: php index.php [move1] [move2] ... [moveN]\n";
            exit(1);
        }
        $uniqueArgs = array_unique($args);
        if (count($args) !== count($uniqueArgs)) {
            echo "Duplicate arguments are not allowed.\n";
            exit(1);
        }
        if (($key = array_search('index.php', $args)) !== false) {
            unset($args[$key]);
        }
        $this->moves = array_values($args);
    }

    public function getMoves() {
        return $this->moves;
    }
}
