<?php

class NamespaceController extends EController
{
    public function actionIndex($errors = null) {
        $namespaces = Namespaces::model()->findAll();

		$this->render('index', array(
            'namespaces' => $namespaces,
            'errors' => $errors
        ));
	}

    public function actionCreate()
    {
        $namespace = new Namespaces();
        $namespace->setAttributes($_REQUEST);
        $namespace->save();
        $this->actionIndex($namespace->getErrors());
    }

    public function actionDelete($id)
    {
        $model = Namespaces::model()->findByPk($id);
        if ($model != null) {
            $model->delete();
        }
        unset(Yii::app()->session['translationsNamespace']);
        $this->actionIndex($model->getErrors());
    }
}