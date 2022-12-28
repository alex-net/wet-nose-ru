<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

class Rubric extends \yii\base\Model
{
    public $id, $pid, $name, $slug, $weight;

    protected static $rubricsList;



    /**
     * поиск конечной рубрики ...
     *
     * @param      <string  $path   Путь от корня до конечной рубрики ..
     */
    public static function findByPath($path)
    {
        $slugs = explode('/', $path);

    }

}