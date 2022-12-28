<?php

namespace app\modules\admin\components;

use yii\helpers\Html;

class RubricsAdminMenuGenBehavior extends \yii\base\Behavior
{
    public function getOneItemElForAdmin($dataEl)
    {
        $label = $dataEl['name'];
        $label .=  Html::a('', ['rubric/edit', 'id' => $dataEl['id']], ['class' => 'fa-solid fa-pen admin-control', 'title' => 'Редактировать']);
        $label .= Html::a('', ['rubric/del', 'id' => $dataEl['id']], ['class' => 'fa-regular fa-trash-can admin-control', 'title' => 'Удалить']);

        return [
            'label' => Html::tag('div', $label),
            'encode' => false,
            'options' => [
                'id' => $dataEl['id'],
            ],
        ];
    }

    /**
     * генераиция списка рубрик для селекта .. с отступами в виде дефисов
     */
    public function listForSelect($pid = null, $level = 1)
    {
        $list = [];
        foreach ($this->owner->rubsList as $rubric) {
            if ($pid == $rubric['pid']) {
                $list[$rubric['id']] = str_repeat('-', $level) . $rubric['name'];
                $list = \yii\helpers\ArrayHelper::merge($list, $this->listForSelect($rubric['id'], $level + 1));
            }
        }

        return $list;
    }

}