<?php

/**
 * Created by PhpStorm.
 * User: chrystian
 * Date: 3/26/16
 * Time: 6:31 PM
 */

namespace chrum\yii2\translations\assets;

use yii\web\AssetBundle;

class TranslationsAssets extends AssetBundle
{
    // the alias to your assets folder in your file system
    public $sourcePath = '@yii2-translations-assets';
    // finally your files..
    public $css = [
        'css/list.css'
    ];
    public $js = [
        'js/scripts.js',
        'js/namespace.js',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}