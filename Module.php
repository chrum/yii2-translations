<?php

namespace chrum\yii2\translations;
use common\models\User;

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
        // In order deal with identityClass issue
        // Both in apiController and migrations
        \Yii::$container->set('user', ['class' => 'yii\web\User', 'identityClass' => 'common\models\User']);
        if (\Yii::$app->has('user')) {
            \Yii::$app->set('user', [
                'class' => 'yii\web\User',
                'identityClass' => 'common\models\User'
            ]);
        }

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
