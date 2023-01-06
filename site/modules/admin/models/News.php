<?php

namespace app\modules\admin\models;

use Yii;

class News extends \app\models\News
{
    public function rules()
    {
        return [
            [['name', 'teaser', 'content'], 'trim'],
            ['name', 'string', 'max' => 100],
            ['teaser', 'string', 'max' => 400],
            ['content', 'string'],
            ['rubid', 'integer'],
            ['rubid', 'in', 'range' => array_keys(Yii::$app->rubrics->rubsList)],
            [['name', 'content', 'rubid'], 'required'],
            ['active', 'boolean'],
            ['name', 'existInCol', 'params' => ['col' => 'name'], 'message' => 'Новость уже есть в базе'],
            ['slug', 'createSlug', 'skipOnEmpty' => false],
            ['slug', 'string', 'max' => 120],
            ['slug', 'existInCol', 'params' => ['col' => 'slug'], 'message' => 'Новость уже есть в базе'],
        ];
    }

    public function existInCol($attr, $params, $validator)
    {
        $where = ['and', ['=', $params['col'], $this->$attr]];
        if ($this->id) {
            $where[] = ['not', ['=', 'id', $this->id]];
        }
        $q = new \yii\db\Query();
        $q->from('{{%news}}');
        $q->where($where);

        if ($q->exists()) {
            $this->addError($attr, $validator->message);
        }
    }


    public function createSlug($attr)
    {
        $this->slug = \URLify::slug($this->name);
    }

    public function attributeLabels()
    {
        return [
            'rubid' => 'Рубрика новости',
            'name' => 'Заголовок',
            'teaser' => 'Анонс',
            'content' => 'Подробный текст',
            'active' => 'Доступно',
        ];
    }

    public function save($data)
    {
        if ($data && !$this->load($data) || !$this->validate()) {
            return false;
        }

        $attrs = $this->getAttributes($this->activeAttributes());
        if ($this->id) {
            Yii::$app->db->createCommand()->update('{{%news}}', $attrs, ['id' => $this->id])->execute();
        } else {
            Yii::$app->db->createCommand()->insert('{{%news}}', $attrs)->execute();
            $this->id = Yii::$app->db->lastInsertID;
        }

        return true;
    }



    public function remove()
    {
        Yii::$app->db->createCommand()->delete('{{%news}}', ['id' => $this->id])->execute();
    }

    public static function getList($filter = null)
    {
        $dp =  parent::getList($filter);
        $dp->pagination->pageSize = 20;
        $dp->sql = 'select n.id, n.name, n.active, n.created, n.rubid, r.name as rubname,  count(c.id) as comments from {{%news}} n left join {{%rubrics}} r on r.id = n.rubid left join {{%comments}} c on c.nid = n.id group by n.id, rubname';
        $dp->params = [];
        return $dp;
    }
}