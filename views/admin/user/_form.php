<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList(\app\models\User::$roles) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
