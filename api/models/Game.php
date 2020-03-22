<?php

namespace app\models;

use app\misc\ReadOnlyValidator;

class Game extends generated\Game
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_COMPLETED = 'COMPLETED';

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['id', ReadOnlyValidator::class, 'when' => function () {
                return !$this->isNewRecord;
            }],
            ['status', 'in', 'range' => [self::STATUS_RUNNING, self::STATUS_COMPLETED]],
        ]);
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            $this->id = \thamtech\uuid\helpers\UuidHelper::uuid();
            $this->status = self::STATUS_RUNNING;
        }
        return parent::save($runValidation, $attributeNames);
    }
}
