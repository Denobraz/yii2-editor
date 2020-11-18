<?php

namespace denobraz\editor\services;

use denobraz\editor\services\converters\EditorElement;
use denobraz\editor\models\Editor;
use yii\helpers\Json;

class EditorService
{
    public $config;

    public function __construct($config = null)
    {
        $this->config = $config;
        if ($this->config === null) {
            $this->config = require (__DIR__ . './../config/main.php');
        }
    }

    public function convert(string $json)
    {
        $content = Json::decode($json);
        $blocks = $content['blocks'];
        $result = "";
        foreach ($blocks as $block) {
            if (isset($this->config[$block['type']])) {
                $elementClassName = $this->config[$block['type']];
                $element = new $elementClassName();
                if ($element instanceof EditorElement) {
                    $result .= $element->convert($block['data']);
                }
            }
        }

        return $result;
    }

    public function findEditor($target)
    {
        return Editor::findOne(['target' => $target]);
    }

    public function updateEditor($target, $content)
    {
        $editor = Editor::findOne(['target' => $target]);
        if ($editor === null) {
            $editor = new Editor(['target' => $target]);
        }
        $editor->content_json = $content;
        $editor->save(false);
    }
}