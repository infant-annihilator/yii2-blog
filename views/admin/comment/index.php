<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
$this->params['breadcrumbs'][] = $this->title;
?>

<br>
<br>
<div class="comment-index ml-5 mr-5">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user.username',
            'text:ntext',
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url,$model,$key)
                    {
                        return Html::a('<span class="badge badge-pill badge-danger">Удалить</span>', ['delete', 'id' => $model['id']], [

                            'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Вы действительно хотите удалить данный комментарий?'),'data-method' => 'post']);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
