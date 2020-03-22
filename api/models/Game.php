<?php

namespace app\models;

use app\misc\BoardValidator;
use app\misc\GameHandler;
use app\misc\ReadOnlyValidator;
use Yii;

class Game extends generated\Game
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_WIN = 'WIN';
    const STATUS_LOSE = 'LOSE';

    /**
     * Yii2 style model validation rules.
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['id', ReadOnlyValidator::class, 'when' => function () {
                return !$this->isNewRecord;
            }],

            ['status', 'in', 'range' => [self::STATUS_RUNNING, self::STATUS_WIN, self::STATUS_LOSE]],

            ['board', function ($attribute) {
                if ($this->status != self::STATUS_RUNNING) {
                    $this->addError($attribute, Yii::t('app', 'The game is already completed.'));
                }
            }],
            ['board', 'match', 'pattern' => '/[X0-]{9}/'],
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
        // and in this case set status to WIN
        // save game and stop execution.
        $gameHandler = new GameHandler([
            'board' => $this->board,
        ]);
        if ($gameHandler->getIsComleted()) {
            $this->status = self::STATUS_WIN;
            return parent::save(FALSE, $attributeNames);
        }

        // Make random move by server
        $gameHandler->makeRandomMove();
        $this->board = $gameHandler->board;
        // If game is completed, set status to LOSE.
        if ($gameHandler->getIsComleted()) {
            $this->status = self::STATUS_LOSE;
        }
        // Save game.
        return parent::save(FALSE, $attributeNames);
    }
}
