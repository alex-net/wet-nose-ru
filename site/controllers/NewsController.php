<?php

namespace app\controllers;

use Yii;
use app\models\Rubric;

class NewsController extends \yii\web\Controller
{
    /**
     * списк новостей ...
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    public function actionIndex($slug = null)
    {
        $rudId = null;
        if ($slug) {
            $rudId = Yii::$app->rubrics->findByPath(explode('/', $slug));
            if (!isset($rudId)) {
                throw new \yii\web\NotFoundHttpException("Страница не найдена");
            }
        }
        return $this->render('list', ['filterByRub' => $rudId]);
    }

    /**
     * Просмотр одной новости
     *
     * @param      string  $id     Идентификатор новости
     */
    public function actionView(string $slug)
    {
        $news = \app\models\News::getBySlug($slug);
        if (!$news || !$news->active){
            throw new \yii\web\NotFoundHttpException('Новость отсутствует');
        }

        $comment = new \app\models\CommentForm(['nid' => $news->id]);
        if ($this->request->isPost && $comment->save($this->request->post())) {
            Yii::$app->session->addFlash('success', 'Коментарий сохранён');
            return $this->refresh();
        }

        return $this->render('view', [
            'model' => $news,
            'comment' => $comment,
        ]);
    }
}