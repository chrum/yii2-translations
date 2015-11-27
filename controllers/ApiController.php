<?php

namespace chrum\yii2\translations\controllers;

use chrum\yii2\translations\helpers\langHelper;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\Response;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => [],
            ],
            'corsFilter' => [
                'class' => Cors::className(),
            ],
        ];
    }

    public function actions()
    {
        $actions = array();
        $langs = langHelper::getLangs();
        foreach($langs as $code => $name) {
            $actions[$code] = 'chrum\yii2\translations\actions\getTranslationsAction';
        }

        return $actions;
    }

    public function runAction($id, $params = [])
    {
        if ($id == '') {
            $langs = langHelper::getLangs();
            $fakeControllerId = $this->id;
            if (array_key_exists($fakeControllerId, $langs)) {
                $id = $fakeControllerId;
            }
        }
        return parent::runAction($id, $params);
    }
}