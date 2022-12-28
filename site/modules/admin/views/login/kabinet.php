<?php

$this->title = 'Кабинет';

echo \yii\widgets\DetailView::widget([
    'model' => $user,
]);

echo \yii\helpers\Html::a('Выйти', ['login/logout']);