<?php

use yii\db\Schema;
use chrum\yii2\translations\helpers\langHelper;

class m141113_082503_addTranslations extends \yii\db\Migration
{
    protected $MySqlOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    protected $tableOptions = null;

	public function up()
	{
        $columns = [
            "id" => $this->primaryKey(),
            "string_id" => $this->string()->notNull(),
        ];

        $langs = langHelper::getLangs();
        foreach($langs as $key => $value) {
            $columns[$key] = $this->string(1025);
        }

        if ($this->db->driverName === 'mysql')
        {
            $this->tableOptions = $this->MySqlOptions;
        }

        $this->createTable("{{%translations}}", $columns, $this->tableOptions);

	}

	public function down()
	{
        $this->dropTable("{{%translations}}");
	}


}