<?php

namespace denobraz\editor\services\converters;

use yii\helpers\Html;

class ListElement implements EditorElement
{
    public function convert(array $element): string
    {
        $style = $element['style'];
        $items = $element['items'];
        $result = Html::beginTag('ul');
        foreach ($items as $item) {
            $result .= Html::tag('li', $item);
        }
        $result .= Html::endTag('ul');

        return $result;
    }
}