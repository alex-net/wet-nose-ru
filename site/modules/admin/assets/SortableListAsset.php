<?php

namespace app\modules\admin\assets;

class SortableListAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@nm/jquery-sortable-lists';
    public $js = ['jquery-sortable-lists.min.js'];
    public $depends = [
        \yii\web\YiiAsset::class,
    ];
}