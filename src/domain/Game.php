<?php

namespace Domain;

class Game
{
    public const MAX_PLAYERS = 6;

    private $playersBets = [];

    function addBet(Player $player, $bet)
    {
        $this->playersBets[$player->getId()] = $bet;
    }

    function play()
    {
        $winningScore = (5) + 1;
        foreach (array_keys($this->playersBets) as $player) {
            if ($winningScore === $this->playersBets[$player->getId()]->score) {
                $player->win($this->playersBets[$player->getId()]->amount * 6);
            } else {
                $player->lose();
            }
        }
        unset($this->playersBets);
    }

    function leave($player)
    {
        if (in_array($player->getId(), array_keys($this->playersBets))) {
            return;
        }

        unset($this->playersBets[$player->getId()]);
    }

    function join(Player $player): void
    {
        $player->joins($this);

        if (\count($this->playersBets) > self::MAX_PLAYERS) {
            throw new CasinoGameException('Max 6 players');
        }

        $this->playersBets[$player->getId()] = [];
    }
}