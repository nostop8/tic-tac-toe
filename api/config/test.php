<?php
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/test_db.php';
$urlRules = require __DIR__ . '/url-rules.php';

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'en-US',
    'components' => [
        'db' => $db,
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => $urlRules,
        'user' => [
            'identityClass' => 'app\models\User',
        ],
        'request' => [
            'baseUrl' => '/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'lSVfsZ20bDvHfDJTYQiZoZtzNKctIDVk',
        ],
        'response' => [
            'class' => 'app\misc\Response',
            // 'format' => 'json',
        ],
    ],
    'params' => $params,
];
