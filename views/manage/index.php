<?php
/* @var $this TranslationsController */
/** @var $models Translations[] */
$this->breadcrumbs=array(
	'Translations',
);
Yii::app()->clientScript->registerCoreScript('jquery');
$langs = langHelper::getLangs();
?>
<script>
    $(document).ready(function() {
        $(".table-row-link").click(function(event) {
            event.preventDefault();
            event.stopImmediatePropagation();
            var target = $(event.target);
            var rowLink = target.data("row-link");
            if (typeof(rowLink) == 'undefined') {
                rowLink = target.parent().data("row-link");
            }
            document.location.href = '<?php echo Yii::app()->getBaseUrl(true); ?>' + rowLink;
            return false;
        });
    })
</script>
<h1>Manage translation strings</h1>

<label>Namespace</label>
<div class="dropdown btn-group">
    <button class="btn dropdown-toggle" type="button" id="categoryMenu" data-toggle="dropdown">
            <span class="title">
                <?php if($currentNamespace == null):?>
                    Show all
                <?php else: ?>
                    <?php echo $currentNamespace ?>
                <?php endif;?>
            </span>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="categoryMenu">
        <li role="presentation" class="<?php echo $currentNamespace == null ? "disabled" : "" ?>">
            <a role="menuitem" tabindex="-1" href="?setNamespace=all">Show all</a>
        </li>
        <?php foreach($namespaces as $namespace):?>
            <li role="presentation" class="<?php echo $namespace->name == $currentNamespace ? "disabled" : "" ?>">
                <a role="menuitem" tabindex="-1" href="?setNamespace=<?php echo $namespace->name?>">
                    <?php echo $namespace->name?>
                </a>
            </li>
        <?php endforeach; ?>
        <li class="divider"></li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="/translations/namespace">Edit namespaces</a>
        </li>
    </ul>
</div>
<div>
    <table class="table table-striped table-hover">
        <thead>
        <tr class="row">
            <th class="col-md-1">ID</th>
            <th class="col-md-5">String ID</th>
            <th class="col-md-1">&nbsp;</th>
            <th class="col-md-6">Danish</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($models as $string): ?>
            <tr class="table-row-link row" data-row-link="/translations/manage/update/id/<?php echo $string->id?>">
                <td><?php echo $string->id; ?></td>
                <td><?php echo $string->string_id; ?></td>
                <td><?php
                    $has = array();
                foreach ($langs as $lang => $name) {
                    if ($string->$lang != '') $has[] = $lang;
                }
                    echo implode(', ', $has);
                ?></td>
                <td><?php echo CHtml::encode($string->dk); ?></td>
            </tr>
        <?php endforeach;?>
        </tbody>

    </table>

</div>
