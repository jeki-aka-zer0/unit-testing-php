<?php

use Domain\CasinoGameException;
use Domain\Game;
use Domain\Player;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testJoinGameShouldFailWhenThereAreMaxPlayers(): void
    {
        $game = new Game();

        for ($i = 0; $i <= Game::MAX_PLAYERS; $i++) {
            $player = new Player('Vasya' . $i);
            $game->join($player);
        }

        $player = new Player('Vasya');
        $this->expectException(CasinoGameException::class);
        $game->join($player);
    }
}