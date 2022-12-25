<?php
$appDir = dirname(__DIR__);
return [
    'id' => 'wet-nose-ru',
    'basePath' => $appDir,
    'aliases' => [
        '@app' => $appDir,
        '@bower' => '@vendor/bower-asset',
    ],
    'components' => [
        'db' => [
            'class'=>\yii\db\Connection::class,
            'dsn'=>'pgsql:host=db;port=5432;dbname=yii2basic',
            'username' => 'postgres',
            'password' => 'pass',
        ],
    ],
];