<?php

namespace tests\unit\models;

use app\misc\BoardException;
use app\misc\BoardHandler;

class BoardHandlerTest extends \Codeception\Test\Unit
{

    static $changeStateSuccess = [
        '---------' => 'X--------',
        'X0-------' => 'X0------X',
    ];

    static $changeStateFail = [
        [
            'initial' => '---------',
            'states' => [
                '---------' => 'No move detected.',
                'X-X------' => 'Only one move per request allowed.',
            ],
        ],
        [
            'initial' => 'X0-------',
            'states' => [
                'X0-------' => 'No move detected.',
                'X0X-----X' => 'Only one move per request allowed.',
                'X00------' => 'You have to use character ',
                'XX-------' => 'You are not allowed to override existing moves.',
            ],
        ],
    ];
    
    public function testChangeStateSuccess()
    {
        foreach (self::$changeStateSuccess as $initState => $nextState) {
            $boardHandler = new BoardHandler([
                'board' => $initState,
            ]);
            expect($boardHandler->changeState($nextState))->equals(null);
        }
    }

    public function testChangeStateFail()
    {
        foreach (self::$changeStateFail as $fail) {
            foreach ($fail['states'] as $state => $erroMessage) {
                $boardHandler = new BoardHandler([
                    'board' => $fail['initial'],
                ]);
                try {
                    $boardHandler->changeState($state);
                } catch (BoardException $ex) {
                    $this->assertStringContainsString($erroMessage, $ex->getMessage());
                }
            }
        }
    }

    public function testChangeStateLineCompletedHorizontal()
    {
        $boardHandler = new BoardHandler([
            'board' => '00-XX-X0-',
        ]);
        $boardHandler->changeState('00-XXXX0-');
        $this->assertEquals(BoardHandler::STATUS_COMPLETED_LINE, $boardHandler->getStatus());
    }

    public function testChangeStateLineCompletedVertical()
    {
        $boardHandler = new BoardHandler([
            'board' => 'X0-X0X---',
        ]);
        $boardHandler->changeState('X0-X0X-0-');
        $this->assertEquals(BoardHandler::STATUS_COMPLETED_LINE, $boardHandler->getStatus());
    }

    public function testChangeStateLineCompletedLeftDiagonal()
    {
        $boardHandler = new BoardHandler([
            'board' => 'X0----0-X',
        ]);
        $boardHandler->changeState('X0--X-0-X');
        $this->assertEquals(BoardHandler::STATUS_COMPLETED_LINE, $boardHandler->getStatus());
    }

    public function testChangeStateLineCompletedRightDiagonal()
    {
        $boardHandler = new BoardHandler([
            'board' => 'XX0X0----',
        ]);
        $boardHandler->changeState('XX0X0-0--');
        $this->assertEquals(BoardHandler::STATUS_COMPLETED_LINE, $boardHandler->getStatus());
    }

    public function testChangeStateNoMovesLeft()
    {
        $boardHandler = new BoardHandler([
            'board' => '0XXXX000-',
        ]);
        $boardHandler->changeState('0XXXX000X');
        $this->assertEquals(BoardHandler::STATUS_NO_MOVES_LEFT, $boardHandler->getStatus());
    }
}
