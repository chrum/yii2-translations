<?php

namespace chrum\yii2\translations\controllers;

use chrum\yii2\translations\helpers\langHelper;
use chrum\yii2\translations\models\TranslationNamespace;
use yii\web\Controller;
use yii\helpers\StringHelper;

class ManageController extends Controller
{

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

    public function actionIndex() {
        if (isset($_REQUEST['setNamespace'])) {
            TranslationNamespace::setCurrent($_REQUEST['setNamespace']);
        }

        $class = \Yii::$app->getModule('translations')->translationsModelClass;
        /* @var $class \yii\db\ActiveRecord */
        $query = $class::find()
            ->orderBy("string_id ASC");

        $currentNamespace = TranslationNamespace::getCurrent();
        if ($currentNamespace != null) {
            $query->where(['like', 'string_id', $currentNamespace . '%', false]);
        };

        $models = $query->all();
        $namespaces = TranslationNamespace::find()->all();

		return $this->render('index', array(
            'models' => $models,
            'namespaces' => $namespaces,
            'currentNamespace' => $currentNamespace
        ));
	}

    public function actionCreate()
    {
        $namespacedClass = \Yii::$app->getModule('translations')->translationsModelClass;
        $class = StringHelper::basename($namespacedClass);
        /* @var $translation \yii\db\ActiveRecord */
        $translation = new $namespacedClass();

        if (isset($_REQUEST[$class])) {
            $translation->setAttributes($_REQUEST[$class]);

            if ($translation->validate()) {
                // TODO: validate namespace
                if (isset($_REQUEST['namespace']) && $_REQUEST['namespace'] != '') {
                    // check if namespace is not already there
                    if (strpos($translation->string_id, $_REQUEST['namespace']) === false) {
                        $translation->string_id = $_REQUEST['namespace'].$translation->string_id;
                    }
                }

                if ($translation->save(false)) {
                    $this->redirect(['manage/update', 'id' => $translation->id]);

                } else {
                    foreach($translation->getFirstErrors() as $attribute => $error) {
                        \Yii::$app->getSession()->setFlash('error', $error);
                    }
                }
            }
        }

        return $this->render('edit', array(
            'model'     => $translation,
            'namespaces' => TranslationNamespace::find()->all(),
            'currentNamespace' => TranslationNamespace::getCurrent()
        ));
    }

    public function actionDelete($id)
    {
        $class = \Yii::$app->getModule('translations')->translationsModelClass;
        /* @var $model \yii\db\ActiveRecord */
        $model = $class::findOne($id);
        if ($model != null) {
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    public function actionUpdate($id)
    {
        $namespacedClass = \Yii::$app->getModule('translations')->translationsModelClass;
        $class = StringHelper::basename(($namespacedClass));
        /* @var $model \yii\db\ActiveRecord */
        $model = $namespacedClass::findOne($id);

        if (isset($_REQUEST[$class])) {
            $model->setAttributes($_REQUEST[$class]);

            if ($model->save()) {
                $this->redirect(['manage/index']);

            } else {
                foreach($model->getFirstErrors() as $attribute => $error) {
                    \Yii::$app->getSession()->setFlash('error', $error);
                }
            }
        }

        return $this->render('edit', array(
            'model'     => $model,
        ));
    }

    public function actionBulkAdd() {
        $class = \Yii::$app->getModule('translations')->translationsModelClass;
        /* @var $translation \yii\db\ActiveRecord */

        $added = 0;
        if (isset($_REQUEST['strings'])) {
            foreach($_REQUEST['strings'] as $string) {
                if ($string != "") {
                    $translation = new $class();
                    $translation->string_id = $string;

                    if ($translation->validate()) {
                        // TODO: validate namespace (use validator)
                        if (isset($_REQUEST['namespace'])) {
                            $translation->string_id = $_REQUEST['namespace'].$translation->string_id;
                        }
                        $translation->save(false);
                        $added++;
                    }
                }

            }
            \Yii::$app->getSession()->setFlash('success', 'Added '.$added.' new language strings.');
        }

        $currentNamespace = TranslationNamespace::getCurrent();
        $namespaces = TranslationNamespace::find()->all();

        return $this->render('bulk_add', array(
            'namespaces' => $namespaces,
            'currentNamespace' => $currentNamespace
        ));
    }
}