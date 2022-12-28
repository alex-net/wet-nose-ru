<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Добавить новость';

$f = ActiveForm::begin();
$btns=[Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save'])];

echo $f->field($model, 'name');
echo $f->field($model, 'active')->checkbox();
echo $f->field($model, 'rubid')->dropDownList(Yii::$app->rubrics->listForSelect(), ['prompt' => 'Не указана']);
echo $f->field($model, 'teaser')->textarea(['rows' => 2]);
echo $f->field($model, 'content')->textarea(['rows' => 5]);

if ($model->id) {
    $btns[] = Html::submitButton('Удалить', ['class' => 'btn btn-danger', 'name' => 'kill']);
}
echo \yii\bootstrap5\ButtonGroup::widget([
    'buttons' => $btns,
]);
ActiveForm::end();



