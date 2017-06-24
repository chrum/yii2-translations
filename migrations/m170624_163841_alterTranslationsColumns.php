<?php

use yii\db\Migration;
use chrum\yii2\translations\helpers\langHelper;

class m170624_163841_alterTranslationsColumns extends Migration
{
    public function up()
    {
        $langs = langHelper::getLangs();
        foreach($langs as $key => $value) {
            $this->alterColumn("{{%translations}}", $key, $this->text());
        }
    }

    public function down()
    {
        $langs = langHelper::getLangs();
        foreach($langs as $key => $value) {
            $this->alterColumn("{{%translations}}", $key, $this->string(1025));
        }
    }
}
