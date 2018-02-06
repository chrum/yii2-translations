<?php
/* @var $this yii\web\View */
/* @var $models [] */
/* @var $currentNamespace String */
/* @var $namespaces chrum\yii2\translations\models\TranslationNamespace[] */

use yii\helpers\Url;
use chrum\yii2\translations\helpers\langHelper;
use yii\helpers\Html;
use \yii\widgets\Pjax;
chrum\yii2\translations\assets\TranslationsAssets::register($this);

$langs = langHelper::getLangs();
$displayedLangs = Yii::$app->session->get('yii2translations_displayedLangs', [langHelper::getDefaultLangCode()]);
?>
<script>
    var listUrl = '<?= Url::to(["manage/index"])?>';
</script>

<h1>Manage translation strings</h1>
<?php Pjax::begin([
    'id' => 'translations-list',
    'formSelector' => '#translations-list-controls',
    'timeout' => 1000
]) ?>
<div class="translations-list-controls">
    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'id' => 'translations-list-controls',
        'action' => Url::to(["manage/index"]),
        'method' => 'get'
    ]); ?>
        <div class="row">
            <label class="col-md-2">Namespace</label>
            <div class="dropdown btn-group">
                <button class="btn btn-xs dropdown-toggle" type="button" id="categoryMenu" data-toggle="dropdown">
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
                <a class="btn btn-xs btn-warning" href="<?= Url::to(["manage/export"]) ?>">Export data</a>
                <a class="btn btn-xs btn-danger" href="<?= Url::to(["manage/import"]) ?>">Import</a>
            </div>
        </div>

        <div class="row">
            <label class="col-md-2">
                Display
            </label>
            <div class="btn-group" data-toggle="buttons">
                <?php foreach($langs as $key => $name): ?>
                    <?= Html::a($name, Url::to(["manage/index", 'toggleLang' => $key]), [
                        'class' => 'display-lang-btn btn btn-xs btn-default '. (in_array($key, $displayedLangs) ? 'active' : ''),
                        'data-lang' => $key,
                        'role' => 'button'
                    ]); ?>
                <?php endforeach;?>
            </div>
        </div>


    <?php \yii\bootstrap\ActiveForm::end(); ?>
</div>

<div class="translations-list">

    <table class="table table-striped table-hover">
        <tbody>
        <?php foreach($models as $string): ?>
            <tr class="table-row-link row">
                <td>
                    <a href="<?= Url::to(['manage/update', 'id' => $string->id], true)?>">
                        <?php echo $string->id; ?> -
                        <strong><?= $string->string_id; ?></strong>
                        <?php foreach($langs as $key => $name): ?>
                            <?php if (empty(trim($string->$key))): ?>
                                <span class="label label-danger"><?= $key ?></span>
                            <?php else:?>
                                <span class="label label-success"><?= $key ?></span>

                            <?php endif;?>
                        <?php endforeach;?>
                    </a>
                </td>
            </tr>
            <tr class="row">
                <td>
                    <table class="translations-table">
                        <tr>
                            <?php foreach($langs as $key => $name): ?>
                                <?php if(in_array($key, $displayedLangs)): ?>
                                    <td>
                                        <?php if(empty($string->{$key})): ?>
                                            <strong><?= $langs[$key] ?></strong> missing

                                        <?php else: ?>
                                            <?php echo Html::encode($string->{$key}); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    </table>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>

    </table>

</div>
<?php Pjax::end() ?>
