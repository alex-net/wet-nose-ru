<?php

use yii\bootstrap5\Html;

echo Html::a('Добавить новость', ['news/edit'], ['class' => 'btn btn-primary']);

echo \yii\grid\GridView::widget([
    'dataProvider' => \app\modules\admin\models\News::getList(),
    'columns' => [
        'id',
        [
            'attribute' => 'name',
            'label' => 'Наименование',
            'format' => 'html',
            'value' => function($m) {
                return Html::a($m['name'], ['news/edit', 'id' => $m['id']]);
            },
        ],
        'active:boolean:Опубликовано',
        'created:datetime:Создан',
        [
            'label' => 'Рубрика',
            'attribute' => 'rubname',
            'format' => 'raw',
            'value' => function($m) {
                if ($m['rubname']) {
                    return Html::a($m['rubname'], ['rubric/edit', 'id' => $m['rubid']], ['target' => '_blank']);
                }
            },
        ],
        'comments:integer:Комментарии',
    ],
]);