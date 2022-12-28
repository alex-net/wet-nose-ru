<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Rubric;

class RubricController extends AdminBaseController
{
    public function actionIndex()
    {
        if ($this->request->isPost) {
            $this->response->format = \yii\web\Response::FORMAT_JSON;
            $tree = $this->request->post('treeData', []);

            if ($tree) {
                Rubric::updateTreeOrders($tree);
                return ['ok' => true];
            }
            return ['ok' => false];
        }
        return $this->render('index');
    }

    private function getModel($id)
    {
        $rubric = Rubric::getById($id);
        if (!$rubric) {
            Yii::$app->session->addFlash('error', "Рубрика удалена ");
            $resp = $this->redirect(['index']);
            $resp->send();
            Yii::$app->end();
        }
        return $rubric;
    }

    public function actionEdit($id = 0)
    {
        $rubric = $id ? $this->getModel($id) : new Rubric();

        if ($this->request->isPost && $rubric->save($this->request->post())) {
            Yii::$app->session->addFlash('success', 'Рубрика '. ($id ? 'обновлена' : 'добавлена') );

            return $id ? $this->redirect(['index']) : $this->refresh();
        }

        return $this->render('edit', ['model' => $rubric]);
    }

    public function actionDel($id)
    {
        $rubric =  $this->getModel($id);
        if ($rubric->kill()) {
            Yii::$app->session->addFlash('success', 'Рубрик(а) удалена');
            return $this->redirect(['index']);
        }

    }
}