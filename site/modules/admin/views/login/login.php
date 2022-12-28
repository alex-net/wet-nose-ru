<?php
use \yii\bootstrap5\ActiveForm;
use \yii\bootstrap5\Html;
$this->title = 'Вход';
$f = ActiveForm::begin();
echo $f->field($model, 'login');
echo $f->field($model, 'pass')->passwordInput();
echo Html::submitButton('Войти', ['class' => 'btn btn-primary']);
ActiveForm::end();
