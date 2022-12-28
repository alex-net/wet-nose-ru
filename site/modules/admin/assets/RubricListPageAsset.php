<?php

namespace app\modules\admin\assets;

class RubricListPageAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@app/modules/admin/front';
    public $js = [
        'js/rubric-list-page.js',
    ];
    public $depends = [
        SortableListAsset::class,
    ];
}