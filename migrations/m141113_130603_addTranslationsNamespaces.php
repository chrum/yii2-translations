<?php
use yii\db\Schema;

class m141113_130603_addTranslationsNamespaces extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%translations_namespaces}}', array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING,
        ));
    }


    public function down()
    {
        $this->dropTable('{{%translations_namespaces}}');
    }
}