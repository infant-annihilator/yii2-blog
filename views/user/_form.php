<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Заголовок', 'class' => 'form-control mt-4 p-3'])->label(false) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true, 'placeholder' => 'Теги', 'class' => 'form-control mt-4 p-3'])->label(false) ?>

    <?= $form->field($uploadImg, 'img')->fileInput(['value' => $model->img, 'class' => 'form-control mt-4 p-3'])->label(false) ?>
    
    <?= $form->field($model, 'text')->textarea(['rows' => 6, 'placeholder' => 'Текст', 'class' => 'form-control mt-4 p-3'])->label(false) ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
