<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $username
 * @property int $password
 * @property int $role
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const ROLE_ADMIN = 0;
    const ROLE_USER = 1;

    static $roles = [
        self::ROLE_ADMIN => "Администратор",
        self::ROLE_USER => "Пользователь",
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            [['role'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }

    /**
     *
     * Если при редактировании пароль не менялся, то он не перезаписывается снова
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (isset($this->oldAttributes['password'])) {
                $oldPass = $this->oldAttributes['password'];
                $newPass = $this->attributes['password'];
                if ($oldPass !== $newPass) {
                    $this->password = md5($this->password);
                }
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return User::find()->all();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return object|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    public function beforeDelete()
    {
        foreach ($this->posts as $post) {
            $post->delete();
        }
        Comment::deleteAll(['user_id' => $this->id]);
        return true;
    }
}
