<?php

namespace denobraz\editor\services\converters;

use yii\helpers\Html;

class Paragraph implements EditorElement
{
    public function convert(array $element): string
    {
        $text = $element['text'];
        return Html::tag('p', $text);
    }
}