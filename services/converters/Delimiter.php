<?php

namespace denobraz\editor\services\converters;

use yii\helpers\Html;

class Delimiter implements EditorElement
{
    public function convert(array $element): string
    {
        return Html::tag('hr');
    }
}