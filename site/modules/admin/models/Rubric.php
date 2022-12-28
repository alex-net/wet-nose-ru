<?php 

namespace app\modules\admin\models;

use Yii;
use yii\helpers\Html;

class Rubric extends \app\models\Rubric
{
    public function rules()
    {
        return [
            ['name', 'trim'],
            ['name', 'string', 'max' => 100],
            ['name', 'required'],
            [['weight', 'pid'], 'integer'],
            ['pid', 'existRub'],
            ['weight', 'default', 'value' => 0],
            ['pid', 'default', 'value' => null],
            ['slug', 'genSlug', 'skipOnEmpty' => false],
        ];
    }

    /**
     * Валидация нличия родительской рубрики
     */
    public function existRub($attr)
    {
        $pid = Yii::$app->db->createCommand('select count(*) from {{%rubrics}} where id = :id', [':id' => $this->$attr])->queryScalar();
        if (!$pid) {
            $this->addError($attr, 'Не известная рубрика');
        }

        if ($this->id && $this->pid) {
            if ($this->id == $this->pid) {
                $this->addError($attr, 'Нарушена иерархия');
            } else {
                $list = Yii::$app->db->createCommand('with recursive t as (select id,pid from rubrics where id = :pid union select r.id,r.pid from rubrics r, t where  r.id = t.pid ) select id from t offset 1', [':pid' => $this->pid])->queryColumn();
                if (in_array($this->id, $list)) {
                    $this->addError($attr, 'Нарушена иерархия');
                }
            }

        }
    }



    public function genSlug($attr)
    {
        $this->slug = \URLify::slug($this->name);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'weight' => 'Вес',
            'pid' => 'Родительская рубрика',
        ];
    }

    public function save($data)
    {
        if ($data && !$this->load($data) || !$this->validate()) {
            return false;
        }

        $attrs = $this->getAttributes($this->activeAttributes());
        if ($this->id) {
            Yii::$app->db->createCommand()->update('{{%rubrics}}', $attrs, ['id' => $this->id])->execute();
        } else {
            Yii::$app->db->createCommand()->insert('{{%rubrics}}', $attrs)->execute();
            $this->id = Yii::$app->db->lastInsertID;
        }
        return true;
    }

    public static function getById($id)
    {
        $res = Yii::$app->db->createCommand('select * from {{%rubrics}} where id = :id', [':id' => $id])->queryOne();
        if (!$res) {
            return;
        }
        return new static($res);
    }


    /**
     * Облова весов и иерархии по рубрикам ... .
     *
     * @param      array  $dataMas  Данные прилетевшие с фронта ...
     */
    public static function updateTreeOrders($dataMas)
    {
        $weights = $pids = $places = $ids = [];
        $co = count($dataMas);
        for ($i = 0; $i < $co; $i++) {
            $ids[] = ":id{$i}";
            $places[":id{$i}"] = intval($dataMas[$i]['id']);
            $places[":weight{$i}"] = intval($dataMas[$i]['order']);
            $places[":pid{$i}"] = isset($dataMas[$i]['parentId']) ? intval($dataMas[$i]['parentId']) : null;

            $weights[] = "when id = :id{$i} then :weight{$i}";
            $pids[] = "when id = :id{$i} then :pid{$i}";
        }
        $sql = sprintf('update {{%%rubrics}} set pid = (case %s end)::int, weight = (case %s end)::int where id in (%s) ', implode(' ', $pids), implode(' ', $weights), implode(', ', $ids) );
        $cmd = Yii::$app->db->createCommand($sql, $places);
        $cmd->execute();

    }

    public function kill()
    {
        if (!$this->id) {
            return false;
        }
        Yii::$app->db->createCommand()->delete('{{%rubrics}}', ['id' => $this->id])->execute();
        return true;
    }
}