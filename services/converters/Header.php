<?php

namespace denobraz\editor\services\converters;

use yii\helpers\Html;

class Header implements EditorElement
{
    public function convert(array $element): string
    {
        $label = $element['level'];
        $text = $element['text'];
        return Html::tag("h".$label, $text);
    }
}