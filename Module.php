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

    public function __construct($id, $parent = null, $config = [])
    {
        // If access is limited, open these for all api methods
        if (isset($config['as access'])) {
            $config['as access']['except'] = [];
            foreach($config['langs'] as $code => $name) {
                $config['as access']['except'][] = $code;
            }
        }
        parent::__construct($id, $parent, $config);
    }

    public function init()
    {
        parent::init();

        foreach($this->langs as $code => $name) {
            $this->controllerMap[$code] = 'chrum\yii2\translations\controllers\ApiController';
        }
    }
}
