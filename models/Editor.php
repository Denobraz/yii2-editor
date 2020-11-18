<?php

namespace denobraz\editor\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "editor".
 *
 * @property int $id
 * @property string|null $content_json
 * @property string $target
 * @property int $created_at
 * @property int $updated_at
 */
class Editor extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'editor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_json'], 'safe'],
            [['target'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['target'], 'string', 'max' => 255],
        ];
    }
}
