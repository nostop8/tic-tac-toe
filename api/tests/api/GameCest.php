<?php

use app\models\Game;
use app\tests\_fixtures\GameFixture;
use Codeception\Util\HttpCode;

class GameCest
{
    public function _before(ApiTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => GameFixture::class,
                'dataFile' => codecept_data_dir() . 'game.php'
            ],
        ]);
    }

    public function gameCreated(ApiTester $I)
    {
        $I->wantTo('Create game');
        $board = '----X----';
        $I->sendPOST('/games', [
            'board' => $board
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => Game::STATUS_RUNNING,
        ]);
    }

    public function gameCreateFailed(ApiTester $I)
    {
        $I->wantTo('Game create failed');
        $board = '---------';
        $I->sendPOST('/games', [
            'board' => $board
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'message' => 'No move detected.',
        ]);
    }

    public function gameUpdated(ApiTester $I)
    {
        $I->wantTo('Update Game (Win)');
        $I->sendPUT('/games/ea51b15c-2618-49dc-aef6-80fe54ec1a7a', [
            'board' => 'X-X0X00-X'
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'status' => Game::STATUS_WIN,
        ]);
    }

    public function gameDeleted(ApiTester $I)
    {
        $I->wantTo('Game Deleted');
        $I->sendDELETE('/games/ea51b15c-2618-49dc-aef6-80fe54ec1a7a');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function gamesIndex(ApiTester $I)
    {
        $I->wantTo('List Games');
        $I->sendGET('/games');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->haveHttpHeader('X-Pagination-Page-Count', 1);
    }

    public function gamesView(ApiTester $I)
    {
        $I->wantTo('List Games');
        $I->sendGET('/games/ea51b15c-2618-49dc-aef6-80fe54ec1a7a');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseContainsJson([
            'board' => 'X-X0-00-X',
        ]);
    }
}
