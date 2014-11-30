<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 10/13/14
 * Time: 6:00 PM
 */

class getTranslationsAction extends CAction
{
    public function run()
    {
        $lang = $this->getId();
        $result = new stdClass();
        if ($lang != '') {
            $availableLangs = langHelper::getLangs();
            $availableLangs['debug'] = 'DEBUG';
            if (array_key_exists($lang, $availableLangs)) {
                $result = langHelper::getTranslations($lang);
            }
        }
        $controller = $this->getController();
        $controller->renderJson($result);
        Yii::app()->end();
    }
}