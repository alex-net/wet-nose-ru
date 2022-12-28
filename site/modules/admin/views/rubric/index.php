<?php

use yii\helpers\Html;

$this->title = 'Управление рубриками';

$rubsTree = Yii::$app->rubrics->listForMenu('getOneItemElForAdmin');

\app\modules\admin\assets\RubricListPageAsset::register($this);

echo Html::a('Добавить рубрику', ['edit'], ['class' => 'btn btn-primary']);

echo \yii\widgets\Menu::widget([
    'options'=>['class' => 'rubrics-admin-view'],
    'items' => $rubsTree,//\app\modules\admin\models\Rubric::listForMenu(),
]);

if ($rubsTree) {
    echo Html::button('Применить', ['class'=>'btn btn-success button-apply-tree-changes', 'disabled' => true]);
}