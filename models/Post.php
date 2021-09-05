<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string|null $img
 *
 * @property TagList[] $tagLists
 */
class Post extends \yii\db\ActiveRecord
{

    public $_tags;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'unique', 'targetAttribute' => 'title', 'message' => 'Заголовок уже был использован. Пожалуйста, введите другой заголовок.'],
            [['title', 'text'], 'required'],
            [['text', 'tags', 'created_at'], 'string'],
            [['user_id'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'tags' => 'Теги',
            'text' => 'Текст',
            'img' => 'Изображение',
            'user_id' => 'Автор',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * После сохранения записи в БД.
     * Если добавлен новый тег, то он сохраняется в бд.
     * Создаёт для поста объект TagList, если он не существовал для вписанных тегов.
     * @param mixed $insert
     * 
     * @return mixed
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        $tags = ($this->_tags == '') ? null : explode(', ', $this->_tags);
        if ($tags != null) {
            foreach ($tags as $tag) {
                $check = Tag::checkTag($tag);

                if (!$check) {
                    $newRelation = new Tag;
                    $newRelation->title = $tag;
                    $newRelation->save();
                } else {
                    $newRelation = Tag::findOne(['title' => $tag]);
                }
                
                $listCheck = TagList::findOne(['post_id' => $this->id, 'tag_id' => $newRelation->id]);

                if ($listCheck == null) {
                    $newTagList = new TagList;
                    $newTagList->post_id = $this->id;
                    $newTagList->tag_id = $newRelation->id;
                    $newTagList->save();
                }
            }
        } else {
            TagList::deleteAll(['post_id' => $this->id]);
        }

        return true;
    }

    /**
     * Gets query for [[TagLists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagLists()
    {
        return $this->hasMany(TagList::className(), ['post_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * Сеттер для тегов
     */
    public function setTags($value)
    {
        $this->_tags = trim($value);
    }

    /**
     * Выводит теги поста через запятую
     */
    public function getTags()
    {
        if (isset($this->tagLists))
        {
            $tagLists = $this->tagLists;
            $tags = [];

            foreach ($tagLists as $list)
            {
                $tag = Tag::findOne($list->tag_id);
                array_push($tags, $tag->title);
            }

            return implode(', ', $tags);
        }
        else
        {
            return $this->_tags;
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        TagList::deleteAll(['post_id' => $this->id]);
        Comment::deleteAll(['post_id' => $this->id]);
        return true;
    }

    /**
     * День создания
     */
    public function getDay()
    {
        $createdAt = new \DateTime($this->created_at);
        return $createdAt->format('d');
    }

    /**
     * Месяц создания
     */
    public function getMonth()
    {
        $createdAt = new \DateTime($this->created_at);
        return $createdAt->format('M');
    }
}
