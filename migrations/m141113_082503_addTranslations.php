<?php
require(__DIR__ . "/../helpers/langHelper.php");
use yii\db\Schema;
use chrum\yii2\translations\helpers\langHelper;

class m141113_082503_addTranslations extends \yii\db\Migration
{
    protected $MySqlOptions = 'ENGINE=InnoDB DEFAULT CHARSET=utf8';
	public function up()
	{
        $columns = [
            "id" => Schema::TYPE_PK,
            "string_id" => Schema::TYPE_STRING." NOT NULL",
        ];

        $langs = langHelper::getLangs();
        foreach($langs as $key => $value) {
            $columns[$key] = "varchar(1024) NULL";
        }

        $this->createTable("{{%translations}}", $columns, $this->MySqlOptions);

	}

	public function down()
	{
        $this->dropTable("{{%translations}}");
	}


}