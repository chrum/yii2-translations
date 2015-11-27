<?php
/* @var $model \yii\db\ActiveRecord */
/* @var $form \yii\widgets\ActiveForm */

use yii\helpers\html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$langs = \chrum\yii2\translations\helpers\langHelper::getLangs();
?>
<h1>
    <?php  if ($model->isNewRecord) : ?>
        Create New String
    <?php else : ?>
        Updating String: <?php echo $model->id; ?>
        <a class="btn btn-danger" href="<?= Url::to(['manage/delete', 'id' => $model->id]) ?>">Delete</a>
    <?php endif; ?>
</h1>

<div class="form base-quiz col-md-12">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'string-translation-form',
            'enableAjaxValidation'=>false,
        ]
    ]); ?>

    <div class="row">
        <?php if ($model->id == null):?>
            <div class="col-md-6">
                <label for="namespace" class="required">Namespace</label>
                <select id="namespace" name="namespace" class="form-control">
                    <option value="">No namespace</option>
                    <?php foreach($namespaces as $ns): ?>
                        <option <?php echo $ns->name == $currentNamespace ? 'selected' : '' ?>>
                            <?php echo $ns->name?>
                        </option>
                    <?php endforeach;?>
                </select>
            </div>
        <?php endif;?>
        <div class="control-group form-group col-md-6">
            <?= $form->field($model, 'string_id')->textInput([
                'maxlength' => true,
                'placeholder' => 'Id to use in app ex. APP_HEADER_TITLE'
            ]) ?>
        </div>
    </div>

    <?php foreach($langs as $key => $name): ?>
        <div class="row form-group">
            <?= $form->field($model, $key)->textarea([
                'rows' => 2,
                'placeholder' => "Translated to ".$name
            ]) ?>
        </div>
    <?php endforeach;?>


    <div class="row buttons">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-danger")); ?>
        <a class="btn btn-primary" href="<?= Url::to(["manage/index"]) ?>">Close</a>
    </div>
    <?php ActiveForm::end(); ?>
</div><!-- form -->