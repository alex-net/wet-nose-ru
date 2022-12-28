<?php
use yii\bootstrap5\ActiveForm;
$this->title = $model->name;

$commnts = $comment->commentsList;
?>

<h1><?= $model->name ?></h1>
<div class="date"><?= $model->created ?></div>
<div class="body"><?= $model->content ?></div>

<h4>(<span title="Число коментариев"><?= $commnts->totalCount ?></span>) Оставить комментарий:</h4>
<?php
$f = ActiveForm::begin();
echo $f->field($comment, 'mail');
echo $f->field($comment, 'content')->textarea(['rows' => 3]);
echo \yii\helpers\Html::submitButton('Отправить', ['class' => 'btn btn-success']);
ActiveForm::end();


echo \yii\grid\GridView::widget([
    'dataProvider' => $commnts,
    'columns' => [
        'id', 'mail', 'content:text:Текст коментария', 'created:datetime:Добавлен',
    ],
]);


