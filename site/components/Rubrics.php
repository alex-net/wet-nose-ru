<?php 

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\base\Event;

class Rubrics extends \yii\base\Component
{
    private $rubsList = [];

    public function init()
    {
        $q = new \yii\db\Query();
        $q->from(['r' => '{{%rubrics}}']);
        $q->select(['r.id', 'r.pid', 'r.name', 'r.slug', 'nn' => new \yii\db\Expression('count(n.id)')]);
        $q->orderBy(['r.weight' => SORT_ASC]);
        $q->indexBy('id');
        $q->leftJoin(['n' => '{{%news}}'], 'n.rubid = r.id and n.active ');
        $q->groupBy('r.id');
        $this->rubsList = $q->all();

        // подсписываемся на событие от виджета .. чтобы подправить элементы меню...
        Event::on(Menu::class, Menu::EVENT_BEFORE_RUN, [$this, 'menuGenHadler']);
    }

    public function menuGenHadler($e)
    {
        if ($e->sender->id != Yii::$app->params['MainMenuName']) {
            return;
        }
        // рекурсивно зачищаем меню от пустых рубрик .
        $this->clearMenu($e->sender->items);
    }

    private function clearMenu(&$items)
    {
        // $items as $ind => $item
        for ($i = 0; $i < count($items); $i++) {
            if (!isset($items[$i]['options']['data-news-count'])) {
                continue;
            }

            if (empty($items[$i]['options']['data-news-count'])) {
                if (!empty($items[$i]['items'])) {
                    $items = \yii\helpers\ArrayHelper::merge($items, $items[$i]['items']);
                    unset($items[$i]['items']);
                }
                $items[$i]['visible'] = false;
            }
            if (!empty($items[$i]['items']))
                $this->clearMenu($items[$i]['items']);
        }
    }



    public function getRubsList()
    {
        return $this->rubsList;
    }

    /**
     * Генерация уровня меню .. из рубрик
     *
     * @param      array  $this->rubsList    список рубрик ....
     * @param      int  $pid    Текущая рубрика для которой генерится подуровень
     */
    public function listForMenu($genFunc = 'getOneItemEl', $pid = null)
    {
        $list = [];
        foreach ($this->rubsList as $rubric) {
            if ($pid == $rubric['pid']) {
                $el = $this->$genFunc($rubric) ;
                $els = $this->listForMenu($genFunc, $rubric['id']);
                if ($els) {
                   $el['items'] = $els;
                }
                $list[] = $el;
            }
        }

        return $list;
    }


    /**
     * формировние одного элемента меню ...
     *
     * @param      array  $dataEl  данные одной рубрики
     *
     * @return     array   элемент меню
     */
    public function getOneItemEl($dataEl)
    {
        $label = $dataEl['name'].'('. $dataEl['nn'] .')';

        return [
            'label' => $label,
            'url' => implode('', $this->slugPath($dataEl['id'])),
            'options' => [
                'data-news-count' => intval($dataEl['nn']),
            ],
            //'visible' => $this->newsExists($dataEl),
        ];
    }

    /*public function newsExists($rubData)
    {
        $newsSum = intval($rubData['nn']);
        foreach ($this->rubsList as $rubCh) {
            if ($rubCh['pid'] == $rubData['id']) {
                $newsSum += $this->newsExists($rubCh);
            }
        }

        return $newsSum > 0;
    }*/


    /**
     * рекурсивное формирование пути для рубрики по её номеру
     *
     * @param      int  $id     номер руббрики ...
     *
     * @return     array   массив из элементов пути ...
     */
    private function slugPath($id)
    {
        $pathArr = [];
        if (empty($this->rubsList[$id])) {
            return $pathArr;
        }
        $pathArr = $this->slugPath($this->rubsList[$id]['pid']);

        $pathArr[] = '/' . $this->rubsList[$id]['slug'];
        return $pathArr;
    }

    public function findByPath(array $slugPath, $ind = 0, $pid = null)
    {
        foreach ($this->rubsList as $rub) {
            if ($rub['pid'] == $pid && $rub['slug'] == $slugPath[$ind]) {
                if (count($slugPath) > $ind +1) {
                    return $this->findByPath($slugPath, $ind + 1, $rub['id']);
                } else {
                    return $rub['id'];
                }
            }
        }

    }
}