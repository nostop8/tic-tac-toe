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
    }

    /**
     * Rest Fields: ['board', 'status'].
     */
    public function actionUpdate()
    {
    }
}
