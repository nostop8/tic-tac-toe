<?php

namespace app\controllers\v1;

use yii\rest\ActiveController;

class GameController extends ActiveController
{
    public $modelClass = 'app\models\Game';

    /**
     * Rest Fields: ['board'].
     */
    public function actionCreate()
    {
        // Dummy method to generate rest fields in documentation tool.
    }

    /**
     * Rest Fields: ['board'].
     */
    public function actionUpdate()
    {
        // Dummy method to generate rest fields in documentation tool.
    }
}
