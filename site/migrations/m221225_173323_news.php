<?php

use yii\db\Migration;

/**
 * Class m221225_173323_news
 */
class m221225_173323_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rubrics}}', [
            'id' => $this->primaryKey()->comment('Ключик категории'),
            'pid' => $this->integer()->unsigned()->comment('Ссылка на родительскую категорию'),
            'name' => $this->string(100)->notNull()->comment('Наименование категории'),
            'slug' => $this->string(120)->notNull()->comment('Транслитизированнныое назнание'),
            'weight' => $this->integer()->notNull()->defaultValue(0)->comment('Вес категориии'),
        ]);
        $this->addCommentOnTable('{{%rubrics}}', 'Рубрики новостей');

        foreach(['slug', 'weight', 'pid'] as $k) {
            $this->createIndex("rubrics-$k-ind", '{{%rubrics}}', [$k]);
        }

        $this->addForeignKey('rubrics-pid-fk', '{{%rubrics}}', ['pid'], '{{%rubrics}}', ['id'], 'cascade', 'cascade');

        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey()->comment('Ключик новости'),
            'active' => $this->boolean()->notNull()->defaultValue(false)->comment('Активная новость'),
            'name' => $this->string(100)->notNull()->comment('Название новости'),
            'slug' => $this->string(120)->notNull()->comment('Транслит названия'),
            'teaser' =>  $this->string(400)->notNull()->defaultValue('')->comment('Краткое содержание'),
            'content' => $this->text()->comment('Содержимоое'),
            'created' => $this->timestamp()->defaultExpression('current_timestamp')->notNull()->comment('дата/время создания'),
            'rubid' => $this->integer()->comment('категория'),
        ]);
        $this->addCommentOnTable('{{%news}}', 'Новости');
        foreach (['active', 'created', 'rubid'] as $k) {
            $this->createIndex("news-$k-ind", '{{%news}}', [$k]);
        }
        $this->createIndex("news-name-ind", '{{%news}}', ['name'], true);
        $this->createIndex("news-slug-ind", '{{%news}}', ['slug'], true);

        $this->addForeignKey('news-rubid-fk', '{{%news}}', ['rubid'], '{{%rubrics}}', ['id'], 'set null', 'cascade');

        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey()->comment('Ключик коментария'),
            'nid' => $this->integer()->notNull()->comment('ссылка на новость'),
            'mail' => $this->string(30)->notNull()->comment('ящик автора'),
            'content' => $this->string(200)->notNull()->comment('Текст коментария'),
            'created' => $this->timestamp()->defaultExpression('current_timestamp')->notNull()->comment('дата создания коментария'),
        ]);
        $this->addCommentOnTable('{{%comments}}', 'Комментарии к новостям');
        foreach (['mail', 'nid', 'created'] as $k) {
            $this->createIndex("coment-$k-ind", '{{%comments}}', [$k]);
        }

        $this->addForeignKey('comment-news-fk', '{{%comments}}', ['nid'], 'news', ['id'], 'cascade', 'cascade');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach(['comments', 'news', 'rubrics'] as $tbl) {
            $this->dropTable($tbl);
        }
    }
}
