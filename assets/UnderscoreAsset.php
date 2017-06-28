<?php
/**
 * Created by PhpStorm.
 * User: kar
 * Date: 6/27/17
 * Time: 2:50 PM
 */

namespace app\assets;
use yii\web\AssetBundle;

class UnderscoreAsset extends AssetBundle
{
    public $sourcePath = '@bower/underscore/';
    public $js = [
        'underscore.js'
    ];
}