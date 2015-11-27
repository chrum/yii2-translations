<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 10/13/14
 * Time: 6:00 PM
 */
namespace chrum\yii2\translations\actions;

use yii\base\Action;
use chrum\yii2\translations\helpers\langHelper;

class getTranslationsAction extends Action
{
    public function runWithParams($params)
    {
        $lang = $this->id;
        $result = new \stdClass();
        if ($lang != '') {
            $availableLangs = langHelper::getLangs();
            $availableLangs['debug'] = 'DEBUG';
            if (array_key_exists($lang, $availableLangs)) {
                $result = langHelper::getTranslations($lang);
            }
        }

        return $result;
    }
}