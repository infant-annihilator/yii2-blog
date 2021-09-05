<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 *
 */
class SignUpForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'password2'], 'required'],
            [['username', 'password', 'password2'], 'string'],
            [['username'], 'uniqueName'],
            [['password', 'password2'], 'comparePassword'],
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
            'password2' => 'Повтор пароля',
        ];
    }

    /**
     * Сравнивает пароли
     * @param $attribute
     * @param $params
     */
    public function comparePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            if ($this->password != $this->password2) {
                $this->addError($attribute, 'Пароли не совпадают');
            }
        }
    }


    /**
     * Проверяет никнейм на уникальность
     * @param $attribute
     * @param $params
     */
    public function uniqueName($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $check = User::findByUsername($this->username);
            if ($check != null) {
                $this->addError($attribute, 'Такое имя уже занято.');
            }
        }
    }

    public function save()
    {
        if ($this->validate()) {
            $user = new User;
            $user->username = $this->username;
            $user->password = md5($this->password);
            $user->role = User::ROLE_USER;
            return $user->save();
        }
        return false;
    }
}
