<?php

namespace app\models;

class User extends \yii\base\Model implements \yii\web\IdentityInterface
{
    const LOGIN = 'login';
    const PASS = 'password';
    public $id, $name;

    /**
     * создаём объект админа (единственнный пользователь)
     *
     * @return     <type>  The admin.
     */
    private static function getAdmin()
    {
        return new static([
            'id' => static::LOGIN,
            'name' => ucfirst(static::LOGIN),
        ]);
    }

    public static function getByLogin(string $login)
    {
        if ($login == static::LOGIN) {
            return static::getAdmin();
        }
    }

    public static function findIdentity($id)
    {
        if($id == static::LOGIN) {
            return static::getAdmin();
        }
    }

    public function attributeLabels()
    {
        return [
            'name'=> 'Имя',
            'id' => 'Идентфикатор',
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null) {}

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return md5($this->id);
    }

    public function validateAuthKey($akey)
    {
        return $akey === $this->getAuthKey();
    }
}