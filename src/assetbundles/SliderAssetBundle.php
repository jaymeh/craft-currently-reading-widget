<?php
namespace jaymeh\craftcurrentlyreadingwidget\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;
use yii\web\JqueryAsset;

class SliderAssetBundle extends AssetBundle
{
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@jaymeh/craftcurrentlyreadingwidget/resources/widgets/slider';

        // define the dependencies
        $this->depends = [
            SlickAssetBundle::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'slider.js',
        ];

        $this->css = [
            'slider.css',
        ];

        parent::init();
    }
}