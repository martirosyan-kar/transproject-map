<?php
/**
 * Created by PhpStorm.
 * User: kar
 * Date: 6/15/17
 * Time: 1:52 AM
 */

namespace app\assets;
use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $sourcePath = '@bower/bxslider-4/dist';
    public $css = [
        'jquery.bxslider.css',
    ];
    public $js = [
        'jquery.bxslider.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}