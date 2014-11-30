<?php
/* @var $this TranslationsController */
/** @var $models Translations[] */
$this->breadcrumbs=array(
	'Translations',
);
Yii::app()->clientScript->registerCoreScript('jquery');
?>
<script>
    $(document).ready(function() {
        $(".form-submit").click(function() {
            $("#namespace-form").submit();
        })
        $(".delete").click(function(event) {
            if (!confirm("Are you sure you want to delete this namespace?")) {
                event.preventDefault();
            }
        })
    })

</script>
<?php if (count($errors) > 0): ?>
    <?php foreach($errors as $error) :?>
        <div class="alert alert-warning fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $error[0] ?>
        </div>
    <?php endforeach;?>
<?php endif;?>


<h1>Namespaces</h1>

<div id="search" class="form-group col-md-4">
    <?php echo CHtml::beginForm("/translations/namespace/create", "POST", array("id" => "namespace-form"));?>
    <div class=" input-group">
        <?php echo CHtml::textField("name", null, array(
            "class" => "form-control",
            "placeholder" => "New namespace",
        )); ?>
        <?php echo CHtml::submitButton("Add", array("class" => "hidden")); ?>
        <span class="input-group-addon form-submit link" data-form="search-form">
            Add
        </span>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<div>
    <table class="table table-striped table-hover">
        <thead>
        <tr class="row">
            <th class="col-md-1">ID</th>
            <th class="col-md-10">Name</th>
            <th class="col-md-1">Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($namespaces as $ns): ?>
            <tr class="row">
                <td><?php echo $ns->id; ?></td>
                <td><?php echo $ns->name; ?></td>
                <td><a href="/translations/namespace/delete?id=<?php echo $ns->id?>" class="btn btn-xs btn-danger delete">Delete</a></td>
            </tr>
        <?php endforeach;?>
        </tbody>

    </table>

</div>
