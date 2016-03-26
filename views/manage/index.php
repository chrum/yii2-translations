<?php
/* @var $this yii\web\View */
/* @var $models [] */
/* @var $currentNamespace String */
/* @var $namespaces chrum\yii2\translations\models\TranslationNamespace[] */

use yii\helpers\Url;
use chrum\yii2\translations\helpers\langHelper;
use yii\helpers\Html;
chrum\yii2\translations\assets\TranslationsAssets::register($this);

$langs = langHelper::getLangs();
?>

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
            <a role="menuitem" tabindex="-1" href="<?= \yii\helpers\Url::to(['namespace/index']) ?>">Edit namespaces</a>
        </li>
    </ul>
</div>

<div class="col-md-4 pull-right" style="text-align: right">
    <a class="btn btn-primary" href="<?= Url::to(["manage/create"]) ?>">Create new</a>
    <a class="btn btn-primary" href="<?= Url::to(["manage/bulk-add"]) ?>">Bulk add</a>
</div>

<div>
    <table class="table table-striped table-hover">
        <thead>
        <tr class="row">
            <th class="col-md-1">ID</th>
            <th class="col-md-5">String ID</th>
            <th class="col-md-1">&nbsp;</th>
            <th class="col-md-6"><?= langHelper::getDefaultLangName() ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($models as $string): ?>
            <tr class="table-row-link row" data-row-link="<?= Url::to(['manage/update', 'id' => $string->id], true)?>">
                <td><?php echo $string->id; ?></td>
                <td><?php echo $string->string_id; ?></td>
                <td><?php
                    $has = array();
                foreach ($langs as $lang => $name) {
                    if ($string->$lang != '') $has[] = $lang;
                }
                    echo implode(', ', $has);
                ?></td>
                <td><?php echo Html::encode($string->{langHelper::getDefaultLangCode()}); ?></td>
            </tr>
        <?php endforeach;?>
        </tbody>

    </table>

</div>
