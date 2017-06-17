<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 6/14/17
 * Time: 6:52 PM
 */

namespace chrum\yii2\translations\validators;

use yii\validators\Validator;

class StringFromListValidator extends Validator
{
    public $options = [];

    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->$attribute, $this->options)) {

            $this->addError($model, $attribute, $attribute . ' must be one of: ' . implode(', ', $this->options));
        }
    }
}