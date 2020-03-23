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
        $boardHandler = new BoardHandler([
            'board' => $model->isNewRecord ? BoardHandler::getEmptyBoard() : $model->getOldAttribute($attribute),
        ]);

        try {
            $boardHandler->changeState($model->{$attribute});
        } catch (BoardException $ex) {
            $this->addError($model, $attribute, $ex->getMessage());
        }
    }
}
