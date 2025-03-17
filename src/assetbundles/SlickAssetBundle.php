<?php
namespace jaymeh\craftcurrentlyreadingwidget\assetbundles;

use yii\web\JqueryAsset;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class SlickAssetBundle extends AssetBundle
{
    public function init()
    {
        $this->depends = [
            JqueryAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js',
        ];

        $this->css = [
            'https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.css',
            'https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/accessible-slick-theme.min.css',
        ];

        parent::init();
    }
}