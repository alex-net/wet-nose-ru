<?php

namespace app\modules\admin;

use Yii;
use yii\base\Event;
use yii\widgets\Menu;

class Module extends \yii\base\Module implements \yii\base\BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->get('urlManager')->addRules([
            'admin' => $this->id . '/login/index',
            'logout' => $this->id . '/login/logout',
            'admin-rubrics' => $this->id . '/rubric/index',
            'admin-rubrics/<id:\d+>' => $this->id . '/rubric/edit',
            'admin-rubrics/<id:\d+>/kill' => $this->id . '/rubric/del',
            'admin-rubrics/add' => $this->id . '/rubric/edit',
            'admin-news' => $this->id . '/news/index',
            'admin-news/<id:\d+>' => $this->id . '/news/edit',
            'admin-news/<id:\d+>/kill' => $this->id . '/news/del',
            'admin-news/add' => $this->id . '/news/edit',

        ], false);
        // заполнение меню ...
        Event::on(Menu::class, Menu::EVENT_BEFORE_RUN, [$this, 'menuGenHadler']);

        $app->get('rubrics')->attachBehavior('adminMenuGen', \app\modules\admin\components\RubricsAdminMenuGenBehavior::class);

        $app->get('user')->loginUrl = [$this->id . '/login/index'];
    }

    public function menuGenHadler($e)
    {
        if ($e->sender->id != Yii::$app->params['MainMenuName']){
            return;
        }

        $itemMenuOptions = ['class' => 'admin-item'];

        Yii::info($e->sender->items, 'items');
        $e->sender->items[] = [
            'label'=>'Новости',
            'options' => $itemMenuOptions,
            'url' => ['/' . $this->id . '/news/index'],
            'visible' => !Yii::$app->user->isGuest,
        ];

        $e->sender->items[] = [
            'label'=>'Рубрики',
            'options' => $itemMenuOptions,
            'url' => ['/' . $this->id . '/rubric/index'],
            'visible' => !Yii::$app->user->isGuest,
        ];

        $e->sender->items[] = [
            'label' => Yii::$app->user->isGuest ? 'Вход' : 'Кабинет',
            'options' => $itemMenuOptions,
            'url' => ['/'. $this->id . '/login/index'],
        ];
    }
}