<?php
require_once "HelpTableGenerator.php";
require_once "HmacCalculator.php";
require_once "KeyGenerator.php";
class Game {
    private $moves;
    private $moveCount;

    public function __construct(array $moves) {
        if (!$this->validateMoves($moves)) {
            throw new Exception("Invalid moves provided");
        }
        $this->moves = array_values($moves);
        $this->moveCount = count($moves);
    }

    private function validateMoves(array $moves): bool {
        return count($moves) >= 3 && count($moves) % 2 == 1 && count($moves) === count(array_unique($moves));
    }

    public function getMoves(): array {
        return $this->moves;
    }

    public function getMoveCount(): int {
        return $this->moveCount;
    }

    public function generateTable() {
        $table = new HelpTableGenerator();
         $tableString = $table->generateTable(['PC\User'] + $this->moves);

        foreach ($this->moves as $pcMove) {
            $row = [$pcMove];
            foreach ($this->moves as $userMove) {
                $result = $this->determineOutcome($pcMove, $userMove);
                $row[] = $result;
            }
           $tableString .= $table->generateTable($row);
        }
        echo $tableString;
    }

    public function determineOutcome($pcMove, $userMove) {
        $pcIndex = array_search($pcMove, $this->moves);
        $userIndex = array_search($userMove, $this->moves);
        $distance = ($userIndex - $pcIndex + $this->moveCount) % $this->moveCount;
        
        if ($distance === 0) return "Draw";
        if ($distance <= ($this->moveCount / 2)) return "Win";
        return "Lose";
    }
}
