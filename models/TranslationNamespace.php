<?php

namespace chrum\yii2\translations\models;

use chrum\yii2\translations\validators\TranslationNamespaceValidator;
use Yii;

/**
 * This is the model class for table "{{%translations_namespaces}}".
 *
 * @property integer $id
 * @property string $name
 */
class TranslationNamespace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%translations_namespaces}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], TranslationNamespaceValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function getCurrent() {
        return \Yii::$app->session->get('translationsNamespace', null);
    }

    public static function setCurrent($namespace) {
        if ($namespace != null) {
            if ($namespace == 'all') {
                \Yii::$app->session->remove('translationsNamespace');
                return;
            }
            $validator = new TranslationNamespaceValidator();
            /*
            if (self::model()->isValidNamespace($namespace)) {
                $availableNamespaces = self::find()->select(['name'])->column();
                foreach($availableNamespaces as $name) {
                    if ($name == $namespace) {
                        Yii::app()->session['translationsNamespace'] = $namespace;
                    }
                }
            }
            */
        }
    }
}
