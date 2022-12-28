<?php

namespace app\models;

use Yii;

class CommentForm extends \yii\base\Model
{
    public $id, $nid, $mail, $content, $created ;

    public function rules()
    {
        return [
            ['mail', 'email'],
            [['mail', 'content'], 'trim'],
            ['nid', 'integer'],
            [['mail', 'content', 'nid'], 'required'],
            ['mail', 'string', 'max' => 30],
            ['content', 'string', 'max' => 200],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mail'=>'Ваша почта',
            'content' => 'Текст комментария',
        ];
    }

    public function save($data)
    {
        if ($data && !$this->load($data) || !$this->validate()) {
            return false;
        }

        $attrs = $this->getAttributes($this->activeAttributes());
        Yii::$app->db->createCommand()->insert('{{%comments}}', $attrs)->execute();

        return true;
    }

    public function getCommentsList()
    {
        if (!$this->nid) {
            return;
        }

        return new \yii\data\SqlDataProvider([
            'sql' => 'select * from {{%comments}} where nid = :nid',
            'params' => [':nid' => $this->nid],
            'pagination' => false,
        ]);

    }
}