<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\News;

class NewsController extends AdminBaseController
{


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionEdit($id = null)
    {
        $model = $id ? News::getById($id) : new News();

        if ($this->request->isPost) {
            $post = $this->request->post();
            switch (true) {
                case isset($post['save']):
                    if ($model->save($post)) {
                        Yii::$app->session->addFlash('success', 'Новость обновлена');
                        return $this->redirect(['index']);
                    }
                    break;

                case isset($post['kill']):
                    $model->remove();
                    return $this->redirect(['index']);
            }
        }

        return $this->render('edit', ['model' => $model]);
    }
}