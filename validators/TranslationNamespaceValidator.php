<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 11/26/15
 * Time: 4:33 PM
 */

namespace chrum\yii2\translations\validators;

use yii\validators\Validator;

class TranslationNamespaceValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (isset($this->$attribute)) {
            if ($this->isValidNamespace($this->$attribute)) {
                //do nothing if its ok
            } else {
                $this->addError($model, $attribute, 'Your namespace is invalid, it should contain only alphanumeric characters and dashes ( _ )');
            }
        }
    }

    public function isValidNamespace($namespace) {
        $alphanumeric = str_replace("_", "", $namespace);
        if (ctype_alnum($alphanumeric)) {
            return true;
        }

        return false;
    }
}