<?php
use yii\helpers\Html;
echo  Html::a($model['name'],['news/view', 'slug' => $model['slug']]);
echo Html::tag('div', $model['teaser'], ['class' => 'teaser']);