<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Редактировать пост';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<br>

<div class="container center-screen h-auto">
        <div class="row mt-4 w-50">
            <div class="col-lg-12">

<h3 class="title-form"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
        'uploadImg' => $uploadImg
    ]) ?>

</div>
</div>
</div>