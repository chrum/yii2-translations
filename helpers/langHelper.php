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
        $namespacedClass = \Yii::$app->getModule('translations')->translationsModelClass;
        /* @var \yii\db\ActiveRecord[] $items */
        $items = $namespacedClass::find()->all();
        $translations = array();
        foreach($items as $item) {
            if ($lang == 'debug') {
                $translations[strtoupper($item->string_id)] = ucwords(str_replace('_',' ',strtolower($item->string_id)));

            } else {
                $translations[strtoupper($item->string_id)] =  ($item->$lang=='') ? $item->dk : $item->$lang;

            }
        }


        return $translations;
    }

    public static function getDefaultLangCode()
    {
        return \Yii::$app->getModule('translations')->defaultLang;
    }

    public static function getDefaultLangName()
    {
        $langs = self::getLangs();
        return $langs[self::getDefaultLangCode()];
    }
}