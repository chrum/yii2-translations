<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 6/11/17
 * Time: 12:49 PM
 */

namespace chrum\yii2\translations\models;


use chrum\yii2\translations\validators\StringFromListValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ImportForm extends Model
{
    public $strategy = 'fill_gaps';
    public $dataFile;

    public $strategies = [
        'fill_gaps',
        'overwrite'
    ];

    public function rules()
    {
        return [
            [['strategy'], 'string'],
            [['strategy'], StringFromListValidator::className(), 'options' => $this->strategies],
            [['dataFile'], 'file'],
            [['dataFile'], 'required'],
        ];
    }

    public function import()
    {
        if ($this->validate()) {
            $string = file_get_contents($this->dataFile->tempName);
            $data = Json::decode($string, true);

            if (isset($data['translations'])) {
                $this->importTranslations($data['translations']);
            }

            if (isset($data['namespaces'])) {
                $this->importNamespaces($data['namespaces']);
            }

            return true;
        }

        return false;
    }

    private function importTranslations($data)
    {
        $namespacedClass = \Yii::$app->getModule('translations')->translationsModelClass;
        $byStringId = ArrayHelper::index($data, 'string_id');

        switch ($this->strategy) {
            case 'overwrite':
                $this->overwriteAll($namespacedClass, $byStringId, 'string_id');
                break;
            case 'fill_gaps':
                $this->addNew($namespacedClass, $byStringId, 'string_id');
                break;
        }
    }

    private function importNamespaces($data)
    {
        $byId = ArrayHelper::index($data, 'name');

        switch ($this->strategy) {
            case 'overwrite':
                $this->overwriteAll(TranslationNamespace::className(), $byId, 'name');
                break;
            case 'fill_gaps':
                $this->addNew(TranslationNamespace::className(), $byId, 'name');
                break;
        }
    }

    private function overwriteAll($modelClass, $data, $index = 'id')
    {
        $allKeys = array_keys($data);
        /* @var \yii\db\ActiveRecord[] $existing */
        /* @var $modelClass \yii\db\ActiveRecord */
        $existing = $modelClass::find()
            ->where([$index => $allKeys])
            ->all();

        $updated = [];
        foreach ($existing as $model) {
            $key = $model->getAttribute($index);
            $updated[] = $key;
            $model->setAttributes($data[$key]);
            $model->save();
            unset($data[$key]);
        }

        $this->addNew($modelClass, $data);
    }

    private function addNew($modelClass, $data, $index = 'id')
    {
        /* @var $modelClass \yii\db\ActiveRecord */
        $existing = $modelClass::find()
            ->select([$index])
            ->where([$index => array_keys($data)])
            ->column();

        foreach($data as $key => $newData) {
            if (!in_array($key, $existing)) {
                /* @var \yii\db\ActiveRecord $model */
                $model = new $modelClass();
                $model->setAttributes($newData);
                $model->save();
            }
        }
    }


}