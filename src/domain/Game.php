<?php

namespace Domain;

class Game
{
    private $playersBets;

    function addBet($player, $bet)
    {
        $this->playersBets[$player] = $bet;
    }

    function play()
    {
        $winningScore = (5) + 1;
        foreach (array_keys($this->playersBets) as $player) {
            if ($winningScore === $this->playersBets[$player]->score) {
                $player->win($this->playersBets[$player]->amount * 6);
            } else {
                $player->lose();
            }
        }
        unset($this->playersBets);
    }

    function leave($player)
    {
        if (in_array($player, array_keys($this->playersBets))) {
            return;
        }

        unset($this->playersBets[$player]);
    }

}