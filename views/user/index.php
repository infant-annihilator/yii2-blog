<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Посты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index ml-5 mr-5">

    <br>
    <br>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('+ Добавить', ['create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($data) {
                    return '<b>'. $data->title. '</b>';
                }
            ],


            [
                'label' => 'Теги',
                'format' => 'raw',
                'value' => function($data){
                    return $data->tags;
                },
            ],


            [
                'attribute' => 'text',
                'value' => function ($data) {
                    return StringHelper::truncate($data->text, 100);
                }
            ],

            [
                'format' => 'raw',
                'value' => function($data)
                {
                    return '<img style="width: 300px" src="../post_images/'. $data->img .'">';
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url,$model,$key)
                    {
                        return Html::a(
                            '<span class="badge badge-pill badge-info">Редактировать</span>',
                            $url);
                    },
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url,$model,$key)
                    {
                        return Html::a('<span class="badge badge-pill badge-danger">Удалить</span>', ['delete', 'id' => $model['id']], [

                            'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Вы действительно хотите удалить данный пост?'),'data-method' => 'post']);
                    },
                ],
            ],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>