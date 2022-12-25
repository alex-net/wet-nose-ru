<?php

$conf = require __DIR__.'/common.php';

return array_merge_recursive($conf, [
    'controllerNamespace' => 'app\controllers',
    'bootstrap' => ['debug'],
    'components' => [
        'request' => [
            'cookieValidationKey' => getenv('cookieValidationKey', ''),
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [],
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
    ],
]);