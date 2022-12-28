<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\modules\admin\models\Rubric;

$this->title = $model->id ? 'Редактирование рубрики' : 'Новая рубрика';

$f = ActiveForm::begin();

echo $f->field($model, 'name');
echo $f->field($model, 'weight');
echo $f->field($model, 'pid')->dropDownList(Yii::$app->rubrics->listForSelect(), ['prompt' => 'Корень']);

echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary']);
ActiveForm::end();