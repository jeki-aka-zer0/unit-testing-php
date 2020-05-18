<?php

use Domain\CasinoGameException;
use Domain\Game;
use Domain\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testJoinGameShouldSuccessWhenPlayerIsNotInGame(): void
    {
        $player = new Player('Vasya');
        $game = new Game();
        $player->joins($game);

        static::assertEquals($game, $player->activeGame());
    }

    public function testJoinGameShouldFailWhenPlayerAlreadyInGame(): void
    {
        $player = new Player('Vasya');
        $game = new Game();
        $player->joins($game);

        $this->expectException(CasinoGameException::class);
        $this->expectExceptionMessage('Player must leave the current game before joining another game');
        $player->joins($game);
    }

    public function testPlayerCanByuChips(): void
    {
        $player = new Player('Vasya');
        $chips1 = 1;
        $chips2 = 2;
        $player->buy($chips1);
        $player->buy($chips2);

        self::assertEquals($chips1 + $chips2, $player->getAvailableChips());
    }

    public function testPlayerCantByuNegativeAmountOfChips(): void
    {
        $player = new Player('Vasya');
        $chips = -1;

        $this->expectException(CasinoGameException::class);
        $this->expectExceptionMessage('Buying negative numbers is not allowed');
        $player->buy($chips);
    }
}
