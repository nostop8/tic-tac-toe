<?php

namespace app\misc;

use Yii;

class Response extends \yii\web\Response
{

    public function init()
    {
        if (strpos(Yii::$app->request->url, 'api/v1/')) {
            $this->format = self::FORMAT_JSON;
        }
        parent::init();
    }
}
