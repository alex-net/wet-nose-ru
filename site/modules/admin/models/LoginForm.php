<?php

namespace app\modules\admin\models;

use app\models\User;
use Yii;

class LoginForm extends \yii\base\Model
{
    public $login, $pass;

    public function rules()
    {
        return [
            [['login','pass'], 'string'],
            [['login','pass'], 'trim'],
            [['login','pass'], 'required'],
            [['login','pass'], 'checUser'],
        ];
    }

    public function checUser($attr)
    {
        if ($this->login != User::LOGIN || $this->pass != User::PASS) {
            foreach (['login', 'pass'] as $f) {
                $this->addError($f, 'Логин или пароль неверны');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'pass' => 'Пароль',
        ];
    }

    public function login(array $data = [])
    {
        if ($data && !$this->load($data) || !$this->validate()) {
            return false;
        }
        Yii::$app->user->login(User::getByLogin($this->login));

        return true;
    }
}