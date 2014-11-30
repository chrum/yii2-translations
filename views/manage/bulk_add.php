<script>
    $(document).ready(function() {
        $("#addMore").click(function(event){
            event.preventDefault();
            var clone = $("#emptyRow").clone();
            clone.removeClass("hidden");
            clone.attr("id", "");
            $("#stringsContainer").append(clone);
        })
    });

</script>

<?php if($added > 0):?>
    <div class="alert alert-success fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        Added <?php echo $added ?> new language strings.
    </div>
<?php endif;?>

<div class="form base-quiz col-md-12">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'string-translation-form',
        'enableAjaxValidation'=>false,

    )); ?>

    <div class="row col-md-6">
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
    <div class="col-md-6">
        <label>Strings to add</label>
        <div id="stringsContainer" class="well">
            <?php for($i = 0; $i < 5; $i++): ?>
                <div class="row">
                    <div class="control-group form-group">
                        <?php echo CHtml::textField("strings[]",'', array("class" => "form-control")); ?>
                    </div>
                </div>
            <?php endfor;?>
        </div>
        <button id="addMore" role="button" class="btn pull-right">Add more</button>
        <div id="emptyRow" class="row hidden">
            <div class="control-group form-group">
                <?php echo CHtml::textField("strings[]",'', array("class" => "form-control")); ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Save', array("class" => "btn btn-danger")); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->