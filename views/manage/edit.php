<?php
/** @var Translations $model */

use yii\helpers\html;

$errors = $model->errors;
if (isset($_SESSION['errors'])) {
    $errors = array_merge($errors, $_SESSION['errors']);
    unset($_SESSION['errors']);
}

$langs = langHelper::getLangs();

?>
<h1>
    <?php  if ($model->isNewRecord) : ?>
        Create New String
    <?php else : ?>
        Updating String: <?php echo $model->id; ?>
        <?php echo CHtml::link('Delete', array('manage/delete', 'id' => $model->id), array('class'=>'btn btn-danger btn-xs delete')); ?>
    <?php endif; ?>
</h1>

<div class="form base-quiz col-md-12">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'string-translation-form',
        'enableAjaxValidation'=>false,

    )); ?>
    <?php if (count($errors) > 0): ?>
        <?php foreach($errors as $error) :?>
            <div class="alert alert-warning fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo $error[0] ?>
            </div>
        <?php endforeach;?>
    <?php endif;?>

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
            <?php echo $form->labelEx($model,'string_id'); ?>
            <?php echo $form->textField($model,'string_id', array("class" => "form-control")); ?>
            <?php echo $form->error($model,'string_id', array("class" => "label label-danger")); ?>
        </div>
    </div>

    <?php foreach($langs as $key => $name): ?>
        <div class="row form-group">
            <?php echo CHtml::label($name, $key); ?>
            <?php echo CHtml::textArea('Translations['.$key.']', isset($model->{$key}) ? $model->{$key} : "", array(
                "placeholder" => "Translated to ".$name,
                "class" => "form-control"
            )); ?>
        </div>
    <?php endforeach;?>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array("class" => "btn btn-danger")); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->