<?php


namespace frontend\assets;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class TaskAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/task.css',
    ];
    public $js = [
        'js/task.js',
        'js/client.js',
    ];
    public $depends = [
        JqueryAsset::class,
    ];

}