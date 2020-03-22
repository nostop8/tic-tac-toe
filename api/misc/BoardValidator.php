<?php

namespace app\misc;

use \yii\db\ActiveRecord;

class BoardValidator extends \yii\validators\Validator
{

    /**
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $gameHandler = new GameHandler([
            'board' => $model->isNewRecord ? GameHandler::getEmptyBoard() : $model->getOldAttribute($attribute),
        ]);

        try {
            $gameHandler->changeState($model->{$attribute});
        } catch (GameException $ex) {
            $this->addError($model, $attribute, $ex->getMessage());
        }
    }
}
