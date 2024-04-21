<?php
class HelpTableGenerator
{
    public static function generateTable($moves)
    {
        $table = self::generateHeader($moves);
        $table .= self::generateRows($moves);
        return $table;
    }

    private static function generateHeader($moves)
    {
        $header = str_pad("PC\User >", 12);
        foreach ($moves as $move) {
            $header .= str_pad($move, 12);
        }
        $header .= "\n" . str_repeat("-", 12 * (count($moves) + 1)) . "\n";
        return $header;
    }

    private static function generateRows($moves)
    {
        $rows = "";
        foreach ($moves as $userMove) {
            $row = str_pad($userMove, 12) . "|";
            foreach ($moves as $compMove) {
                $row .= str_pad(
                    self::determineWinner($userMove, $compMove, $moves),
                    12
                );
            }
            $rows .= $row . "\n";
        }
        return $rows;
    }

    private static function determineWinner($userMove, $compMove, $moves)
    {
        $userIndex = array_search($userMove, $moves);
        $computerIndex = array_search($compMove, $moves);
        $halfCount = count($moves) / 2;

        if ($userIndex === false || $computerIndex === false) {
            return "Invalid move";
        }

        $distance =
            ($computerIndex - $userIndex + count($moves)) % count($moves);

        if ($distance == 0) {
            return "Draw!";
        } elseif ($distance <= $halfCount) {
            return "You win!";
        } else {
            return "You lose!";
        }
    }
}
