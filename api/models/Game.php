<?php

namespace app\models;

use app\misc\BoardValidator;
use app\misc\BoardHandler;
use app\misc\ReadOnlyValidator;
use Yii;

class Game extends generated\Game
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_WIN = 'WIN';
    const STATUS_LOSE = 'LOSE';
    const STATUS_DRAW = 'DRAW';

    /**
     * Yii2 style model validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['id', ReadOnlyValidator::class, 'when' => function () {
                return !$this->isNewRecord;
            }],

            ['status', 'in', 'range' => [self::STATUS_RUNNING, self::STATUS_WIN, self::STATUS_LOSE, self::STATUS_DRAW]],

            ['board', function ($attribute) {
                if ($this->status != self::STATUS_RUNNING) {
                    $this->addError($attribute, Yii::t('app', 'The game is already completed.'));
                }
            }],
            ['board', 'match', 'pattern' => '/[X0-]{9}/'],
            ['board', 'match', 'pattern' => '/[X-]{9}/', 'when' => function () {
                return $this->isNewRecord;
            }, 'message' => Yii::t('app', 'Game should always start using "X" character.')],
            ['board', BoardValidator::class],

        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // Set ID and status.
        if ($this->isNewRecord) {
            $this->id = \thamtech\uuid\helpers\UuidHelper::uuid();
            $this->status = self::STATUS_RUNNING;
        }

        if ($runValidation && !$this->validate($attributeNames)) {
            return FALSE;
        }

        // Check if game is completed by client
        // and in this case set status to WIN or DRAW,
        // save game and stop execution.
        $boardHandler = new BoardHandler([
            'board' => $this->board,
        ]);
        if (($status = $boardHandler->getStatus())) {
            if ($status == BoardHandler::STATUS_COMPLETED_LINE) {
                $this->status = self::STATUS_WIN;
            } else {
                $this->status = self::STATUS_DRAW;
            }
            return parent::save(FALSE, $attributeNames);
        }

        // Make random move by server.
        $boardHandler->makeRandomMove();
        $this->board = $boardHandler->board;
        // If game is completed, set status to LOSE or DRAW.
        if (($status = $boardHandler->getStatus())) {
            if ($status == BoardHandler::STATUS_COMPLETED_LINE) {
                $this->status = self::STATUS_LOSE;
            } else {
                $this->status = self::STATUS_DRAW;
            }
        }
        // Save game.
        return parent::save(FALSE, $attributeNames);
    }
}
