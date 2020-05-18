<?php

use Domain\CasinoGameException;
use Domain\Game;
use Domain\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @var Player
     */
    private $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->player = new Player('Vasya');
    }

    public function testJoinGameShouldSuccessWhenPlayerIsNotInGame(): void
    {
        $game = new Game();

        $this->player->joins($game);

        static::assertEquals($game, $this->player->activeGame());
    }

    public function testJoinGameShouldFailWhenPlayerAlreadyInGame(): void
    {
        $game = new Game();
        $this->player->joins($game);

        $this->expectException(CasinoGameException::class);
        $this->expectExceptionMessage('Player must leave the current game before joining another game');
        $this->player->joins($game);
    }

    public function testPlayerCanByuChips(): void
    {
        $chips1 = 1;
        $chips2 = 2;
        $this->player->buy($chips1);

        $this->player->buy($chips2);

        self::assertEquals($chips1 + $chips2, $this->player->getAvailableChips());
    }

    public function testPlayerCantByuNegativeAmountOfChips(): void
    {
        $chips = -1;

        $this->expectException(CasinoGameException::class);
        $this->expectExceptionMessage('Buying negative numbers is not allowed');
        $this->player->buy($chips);
    }
}
