<?php

$dateProvider = \app\models\News::getList($filterByRub);
echo $dateProvider->sort->link('created', ['label' => 'Дата создания']);
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dateProvider,
    'itemView' => 'list-item',
    'itemOptions' => ['class' => 'item'],
    'options' => [
        'class' => 'news-list',
    ],
]);