<?php

$conf = require __DIR__.'/common.php';

return array_merge_recursive($conf, [
    'aliases' => [
        '@nm' => '@app/front/node_modules',
    ],
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['debug', 'adminka'],
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('cookieValidationKey', ''),
        ],
        'rubrics' => \app\components\Rubrics::class,
        'user' => [
            'identityClass' => \app\models\User::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '/' => 'news/index',
                'news/<slug>' => 'news/view',
                '/<slug:.*>' => 'news/index',
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => \yii\debug\Module::class,
            'allowedIPs' => ['*'],
        ],
        'adminka' => [
            'class' => \app\modules\admin\Module::class,
        ],
    ],
]);