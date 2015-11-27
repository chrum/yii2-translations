<?php

use yii\db\Schema;
use chrum\yii2\translations\helpers\langHelper;

class m141113_082503_addTranslations extends \yii\db\Migration
{
    protected $MySqlOptions = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';
	public function up()
	{
        $columns = [
            "id" => $this->primaryKey(),
            "string_id" => $this->string()->notNull(),
        ];

        $langs = langHelper::getLangs();
        foreach($langs as $key => $value) {
            $columns[$key] = $this->string(1024);
        }

        $this->createTable("{{%translations}}", $columns, $this->MySqlOptions);

	}

	public function down()
	{
        $this->dropTable("{{%translations}}");
	}


}