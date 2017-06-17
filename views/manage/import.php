<?php
/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 6/11/17
 * Time: 12:29 PM
 */
/* @var $model ImportForm */
use \yii\bootstrap\Html;
use \yii\bootstrap\ActiveForm;
use chrum\yii2\translations\models\ImportForm;
?>


<div>

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]); ?>


    <div class="form-group">
        <?= $form->field($model, 'strategy')->radioList([
            'fill_gaps' => 'Fill missing data',
            'overwrite' => 'Overwrite any existing data'
        ])->label('Choose import strategy'); ?>
    </div>


    <div class="form-group">
        <?= $form->field($model, 'dataFile')->fileInput()->label('Select data file') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
