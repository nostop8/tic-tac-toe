<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => 'v1/game',
            'tokens' => [
                '{id}' => '<id:[a-z0-9-]{36}>'
            ],
        ]
    ],
];
