<?php

namespace chrum\yii2\translations\controllers;

use chrum\yii2\translations\helpers\langHelper;
use chrum\yii2\translations\models\TranslationNamespace;
use common\models\Translation;
use yii\web\Controller;

class ManageController extends Controller
{

    public function actions()
    {
        $actions = array();
        $langs = langHelper::getLangs();
        foreach($langs as $code => $name) {
            $actions[$code] = 'translations.actions.getTranslationsAction';
        }

        return $actions;
    }

    public function actionIndex() {
        if (isset($_REQUEST['setNamespace'])) {
            TranslationNamespace::setCurrent($_REQUEST['setNamespace']);
        }

        $query = Translation::find()
            ->orderBy("string_id ASC");

        $currentNamespace = TranslationNamespace::getCurrent();
        if ($currentNamespace != null) {
            $query->where(['like', 'string_id', $currentNamespace]);
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
        $translation = new Translations();

        if (isset($_REQUEST['Translations'])) {
            $translation->attributes = $_REQUEST['Translations'];

            if ($translation->validate()) {
                if (isset($_REQUEST['namespace']) && Namespaces::model()->isValidNamespace($_REQUEST['namespace'])) {
                    $translation->string_id = $_REQUEST['namespace'].$translation->string_id;
                }

                if ($translation->save(false)) {
                    $this->redirect(array('index'));
                }
            }
        }

        if ($translation->id != null) {
            $this->redirect(array('update','id'=>$translation->id));
        }

        $currentNamespace = Namespaces::getCurrent();
        $namespaces = Namespaces::model()->findAll();

        $this->render('edit', array(
            'model'     => $translation,
            'namespaces' => $namespaces,
            'currentNamespace' => $currentNamespace
        ));
    }

    public function actionDelete($id)
    {
        $model = Translations::model()->findByPk($id);
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
        $model = Translations::model()->findByPk($id);

        if (isset($_REQUEST['Translations'])) {
            $model->attributes = $_REQUEST['Translations'];

            if ($model->validate()) {
                if ($model->save(false)) {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('edit', array(
            'model'     => $model,
        ));
    }

    public function actionBulkAdd() {
        $added = 0;
        if (isset($_REQUEST['strings'])) {
            foreach($_REQUEST['strings'] as $string) {
                if ($string != "") {
                    $translation = new Translations();
                    $translation->string_id = $string;

                    if ($translation->validate()) {
                        if (isset($_REQUEST['namespace']) && Namespaces::model()->isValidNamespace($_REQUEST['namespace'])) {
                            $translation->string_id = $_REQUEST['namespace'].$translation->string_id;
                        }
                        $translation->save(false);
                        $added++;
                    }
                }

            }
        }

        $currentNamespace = Namespaces::getCurrent();
        $namespaces = Namespaces::model()->findAll();
        $this->render('bulk_add', array(
            'namespaces' => $namespaces,
            'currentNamespace' => $currentNamespace,
            'added' => $added
        ));
    }
}