<?php

namespace app\models;

use Yii;

class News extends \yii\base\Model
{
    public $id, $name, $rubid, $teaser, $content;
    public $created, $active, $slug;


    public static function getById(int $id)
    {
        $res = Yii::$app->db->createCommand('select * from {{%news}} where id = :id', [':id' => $id])->queryOne();
        if ($res) {
            return new static($res);
        }
    }

    public static function getBySlug(string $slug)
    {
        $res = Yii::$app->db->createCommand('select * from {{%news}} where slug = :slug', [':slug' => $slug])->queryOne();
        if ($res) {
            return new static($res);
        }
    }


    public static function getList($filter = null)
    {
        $where = ['and', ['active' => true]];
        $q = new \yii\db\Query();
        $q->from('{{%news}}');
        $q->select(['id', 'name', 'active',  'created', 'slug', 'teaser']);

        if (!empty($filter)) {
            $where[] = ['=', 'rubid', $filter ];
        }
        $q->where($where);
        $cmd = $q->createCommand();
        return new \yii\data\SqlDataProvider([
            'sql' => $cmd->sql,
            'params' => $cmd->params,
            'pagination' => [
                'pageSize' => 3,
            ],
            'sort' => [
                'attributes' => ['id', 'created', 'name'],
                'defaultOrder' => ['created' => SORT_DESC],
            ],
        ]);
    }

}