<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container center-screen">

    <div class="form w-30 text-center">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            // 'layout' => 'horizontal',
        ]); ?>

        <!-- <form class="form w-30 text-center"> -->
        <h3 class="logo-auth">Регистрация</h3>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => "form-control mt-4 p-3", 'placeholder' => 'логин']) ?>
        <?= $form->field($model, 'password')->textInput(['type' => 'password', 'autofocus' => true, 'class' => "form-control mt-4 p-3", 'placeholder' => 'пароль']) ?>
        <?= $form->field($model, 'password2')->textInput(['type' => 'password', 'autofocus' => true, 'class' => "form-control mt-4 p-3", 'placeholder' => 'повтор пароля']) ?>
        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-my bg-transparent w-100 mt-4 mb-4', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>

    </div>
</div>
