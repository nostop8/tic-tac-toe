<?php

namespace app\misc;

use yii\db\ActiveRecord;

class ReadOnlyValidator extends \yii\validators\Validator
{

    /**
     * 
     * @param ActiveRecord $model
     * @param string $attribute
     */
    public function validateAttribute($model, $attribute)
    {
        $model->$attribute = $model->getOldAttribute($attribute);
    }
}
