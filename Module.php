<?php

namespace chrum\yii2\translations;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'chrum\yii2\translations\controllers';

    public $defaultRoute = 'manage';

    public $defaultLang = 'en';

    public $translationsModelClass = 'common\models\Translation';
    /**
     * @var array Array with available languages
     */
    public $langs = array(
        'en' => 'English'
    );

    public function init()
    {
        parent::init();

        foreach($this->langs as $code => $name) {
            $this->controllerMap[$code] = 'chrum\yii2\translations\controllers\ApiController';
        }
    }
}
