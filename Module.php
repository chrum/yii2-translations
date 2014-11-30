<?php

namespace chrum\yii2\translations;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'chrum\yii2\translations\controllers';

    //public $defaultController='default';

    public $defaultLang = "en";
    /**
     * @var array Array with available languages
     */
    public $langs = array(
        "en" => "English"
    );

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}