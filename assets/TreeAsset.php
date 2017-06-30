<?php
/**
 * Created by PhpStorm.
 * User: kar
 * Date: 6/30/17
 * Time: 1:17 AM
 */

namespace app\assets;
use yii\web\AssetBundle;


class TreeAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-treeview/dist';
    public $css = [
        'bootstrap-treeview.min.css',
    ];
    public $js = [
        'bootstrap-treeview.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}