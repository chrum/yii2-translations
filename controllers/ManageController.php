<?php

namespace chrum\yii2\translations\controllers;

use chrum\yii2\translations\helpers\langHelper;
use chrum\yii2\translations\models\ImportForm;
use chrum\yii2\translations\models\TranslationNamespace;
use common\models\Translation;
use yii\web\Controller;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

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

    public function actionIndex()
    {
        if (isset($_REQUEST['setNamespace'])) {
            TranslationNamespace::setCurrent($_REQUEST['setNamespace']);
        }

        $availableLangs = array_keys(langHelper::getLangs());
        if (isset($_REQUEST['toggleLang']) && in_array($_REQUEST['toggleLang'], $availableLangs)) {
            $displayedLangs = \Yii::$app->session->get('yii2translations_displayedLangs', []);
            if (in_array($_REQUEST['toggleLang'], $displayedLangs)) {
                $displayedLangs = array_diff($displayedLangs, [$_REQUEST['toggleLang']]);
                if (count($displayedLangs) === 0) {
                    $displayedLangs[] = langHelper::getDefaultLangCode();
                }

            } else {
                $displayedLangs[] = $_REQUEST['toggleLang'];
            }

            \Yii::$app->session->set('yii2translations_displayedLangs', $displayedLangs);
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

    public function actionBulkAdd()
    {
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

    public function actionExport()
    {
        $namespacedClass = \Yii::$app->getModule('translations')->translationsModelClass;
        $translations = $namespacedClass::find()->asArray()->all();
        $namespaces = TranslationNamespace::find()->asArray()->all();

        array_walk($translations, function (&$item) {
            unset($item['id']);
        });
        array_walk($namespaces, function (&$item) {
            unset($item['id']);
        });

        $data = [
            'translations' => $translations,
            'namespaces' => $namespaces
        ];

        $filename = \Yii::getAlias('@runtime') . '/' . 'Translations.' . time() . '.json';
        file_put_contents($filename, json_encode($data));

        header('Content-type: text/csv');
        header('Content-length:' . filesize($filename));
        header('Content-Disposition: attachment; filename="Translations_' . date('Y-m-d H:i:s') . '.json"');
        readfile($filename);

        unlink($filename);
    }

    public function actionImport()
    {
        $model = new ImportForm();

        if (\Yii::$app->request->isPost) {
            $model->setAttributes(\Yii::$app->request->getBodyParam('ImportForm'));
            $model->dataFile = UploadedFile::getInstance($model, 'dataFile');
            if ($model->import()) {
                // file is uploaded successfully
                return $this->redirect('index');
            }
        }

        return $this->render('import', [
            'model' => $model
        ]);
    }
}