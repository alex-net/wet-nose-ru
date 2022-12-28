<?php

namespace app\modules\admin\controllers;


class AdminBaseController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ]
        ];
    }
}