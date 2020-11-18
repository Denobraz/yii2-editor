<?php

namespace denobraz\editor\assets;

use yii\web\AssetBundle;

class EditorAsset extends AssetBundle
{
    public $sourcePath = __DIR__.'/dist';

    public $js = [
        'editor.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}