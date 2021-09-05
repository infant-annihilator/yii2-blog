<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $title
 *
 * @property TagList[] $tagLists
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[TagLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagLists()
    {
        return $this->hasMany(TagList::className(), ['tag_id' => 'id']);
    }

    /**
     * Проверяет по названию, существует ли тег.
     * @param string $tag Тег для проверки
     */
    public static function checkTag($tag)
    {
        $check = Tag::findOne(['title' => $tag]);

        if ($check == null)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        $check = TagList::findOne(['tag_id' => $this->id]);
        if ($check != null) {
            return false;
        }
        return true;
    }
}
