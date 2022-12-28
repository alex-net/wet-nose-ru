<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\LoginForm;

class LoginController extends \yii\web\Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->render('kabinet', ['user' => Yii::$app->user->identity]);
        }
        $form = new LoginForm();

        if ($this->request->isPost && $form->login($this->request->post())) {
            Yii::$app->session->addFlash('success', 'Успещный вход');
            return $this->refresh();
        }
        return $this->render('login', ['model' => $form]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }
}