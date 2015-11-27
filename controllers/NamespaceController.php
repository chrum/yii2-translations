<?php
namespace chrum\yii2\translations\controllers;
use chrum\yii2\translations\models\TranslationNamespace;

class NamespaceController extends \yii\web\Controller
{
    public function actionIndex($errors = null) {
        $namespaces = TranslationNamespace::find()->all();

		return $this->render('index', array(
            'namespaces' => $namespaces,
            'errors' => $errors
        ));
	}

    public function actionCreate()
    {
        $namespace = new TranslationNamespace();
        $namespace->setAttributes($_REQUEST);
        $namespace->save();

        return $this->actionIndex($namespace->getErrors());
    }

    public function actionDelete($id)
    {
        $model = TranslationNamespace::findOne($id);
        /* @var $model TranslationNamespace */
        if ($model != null) {
            $model->delete();
        }

        return $this->actionIndex($model->getErrors());
    }
}