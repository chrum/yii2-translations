<?php
namespace chrum\yii2\translations\helpers;

class langHelper {
    public static function getLangs() {
        $translations = \Yii::$app->getModule('translations');
        return $translations->langs;
    }
    public static function getCurrentLang() {
        if (isset($_SESSION['lang'])) {
            return $_SESSION['lang'];

        } else {
            return \Yii::$app->getModule('translations')->defaultLang;
        }
    }

    public static function getTranslations($lang)
    {
        /** @var Translations[] $items */
        $items = Translations::model()->findAll();
        /*$items = Yii::app()->db->createCommand()
            ->select('string_id, '.$lang)
            ->from(Translations::model()->tableName())
            ->queryAll();*/
        $translations = array();
        foreach($items as $item) {
            $translations[strtoupper($item->string_id)] = $lang == 'debug' ? ucwords(str_replace('_',' ',strtolower($item->string_id))) : (($item->$lang=='') ? $item->dk : $item->$lang);
        }


        return $translations;
    }
}