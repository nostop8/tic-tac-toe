<?php

use app\models\Game;
use Codeception\Test\Unit;
use app\tests\_fixtures\GameFixture;

class GameModelTest extends Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;


    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => GameFixture::class,
                'dataFile' => codecept_data_dir() . 'game.php'
            ]
        ]);
    }

    public function testStartCharCorrect()
    {
        $game = new Game();
        $game->board = 'X--------';
        expect($game->save())->equals(TRUE);
    }

    public function testStartCharInvalid()
    {
        $game = new Game();
        $game->board = '-0-------';
        expect($game->save())->equals(FALSE);
        expect($game->getFirstError('board'))->equals('Game should always start using "X" character.');
    }

    public function testDraw()
    {
        $game = Game::findOne('faede872-a75e-453e-b7eb-29a70f7c7e85');
        $game->board = '0XXXX000X';
        $game->save();
        expect($game->status)->equals(Game::STATUS_DRAW);
    }

    public function testWin()
    {
        $game = Game::findOne('ea51b15c-2618-49dc-aef6-80fe54ec1a7a');
        $game->board = 'X-X0X00-X';
        $game->save();
        expect($game->status)->equals(Game::STATUS_WIN);
    }

    public function testLose()
    {
        $game = Game::findOne('907e6592-b2cf-4dc1-b282-b141735952ad');
        $game->board = '00-0XX-XX';
        $game->save();
        expect($game->status)->equals(Game::STATUS_LOSE);
    }

    public function testAlreadyCompleted()
    {
        $game = Game::findOne('96d3e336-71df-4877-a7fb-3689484167f7');
        $game->board = '0XXXX000X';
        expect($game->save())->equals(FALSE);
        expect($game->getFirstError('board'))->equals('The game is already completed.');
    }
}
