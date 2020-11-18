<?php

namespace denobraz\editor\services\converters;

use yii\helpers\Html;

class Image implements EditorElement
{
    public function convert(array $element): string
    {
        $src = $element['file']['url'];
        return Html::img($src, ['class' => 'img-fluid']);
    }
}