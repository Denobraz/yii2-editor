<?php

namespace denobraz\editor\behaviors;

use denobraz\editor\services\EditorService;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class EditorBehavior extends Behavior
{
    public $editorTargetAttribute = 'post';

    public $contentAttribute = 'content';

    public $jsonContentAttribute = 'jsonContent';

    public $converterConfig = null;

    public $editorServiceClass = null;

    public $editorService = null;

    public function init()
    {
        parent::init();

        if ($this->editorServiceClass === null) {
            $this->editorServiceClass = EditorService::class;
        }

        $class = $this->editorServiceClass;

        $this->editorService = new $class($this->converterConfig);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_UPDATE => 'convertEditor',
            ActiveRecord::EVENT_BEFORE_INSERT => 'convertEditor',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateEditor',
            ActiveRecord::EVENT_AFTER_INSERT => 'updateEditor',
            ActiveRecord::EVENT_AFTER_FIND => 'findEditor',
        ];
    }

    public function convertEditor()
    {
        $this->owner->{$this->contentAttribute} = $this->editorService->convert($this->owner->{$this->jsonContentAttribute});
    }

    public function findEditor()
    {
        $editor = $this->editorService->findEditor($this->getEditorTarget());
        $this->owner->{$this->jsonContentAttribute} = ($editor !== null) ? $editor->content_json : '';
    }

    public function updateEditor()
    {
        $this->editorService->updateEditor($this->getEditorTarget(), $this->owner->{$this->jsonContentAttribute});
    }

    public function getEditorTarget()
    {
        return $this->editorTargetAttribute . '_' . $this->owner->id;
    }
}
