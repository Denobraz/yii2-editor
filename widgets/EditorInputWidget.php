<?php

namespace denobraz\editor\widgets;

use denobraz\editor\assets\EditorAsset;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class EditorInputWidget extends InputWidget
{
    public $uploadFile;
    public $uploadLink;
    public $uploadUrl;

    public function run()
    {
        parent::run();

        $input = Html::tag('div', '', ['id' => $this->options['id'] . '_eJS']);
        if (!empty($this->model)) {
            $input .= Html::activeHiddenInput($this->model, $this->attribute, $this->options);
        } else {
            $input .= Html::hiddenInput($this->name, $this->value, $this->options);
        }

        $this->registerAssets();

        echo $input;
    }

    public function registerAssets()
    {
        $view = $this->getView();
        EditorAsset::register($view);

        $id = $this->options['id'];
        $containerId = $id . '_eJS';

        $js = <<<JS
        new eJS('{$containerId}', '{$id}', '{$this->uploadFile}', '{$this->uploadUrl}', '{$this->uploadLink}');
JS;

        $view->registerJs($js, $view::POS_READY);
    }
}