<?php
$this->title = $post->title;
?>
<main class="pt-nav">
    <div class="img-wrap">
        <div class="card-img-top div-card-top single-post mt-4"
             style="background: url('../post_images/<?= $post->img ?>') no-repeat;
                background-position: center;
                background-size: cover;
                border-radius: 0 !important;">
        <h2 class="img-inner">
            <span>
                <?= $post->title ?> &nbsp;
                <div class="card-text text-left date-card tag">
                    <span class="float-left">
                        <?php foreach ($tags as $tag) {
                            echo '<span>'. $tag->tag->title .'</span>';
                        }
                        ?>
                    </span>
                </div>
            </span>
        </h2>
    </div>

    <div class="card-body pl-5 pr-5">
        <p class="card-text text-left card-description post-description">
            автор: <b><?= $post->user->username ?></b>
            <br>
            <b><?= $post->created_at ?></b>
            <br>
            <?= $post->text ?>
        </p>

        <ul class="timeline">
            <?php if (!Yii::$app->user->isGuest) { ?>
                <li>
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title"><?= Yii::$app->user->identity->username ?></h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?= date("Y-m-d H:i:s") ?> </small></p>
                            <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['add-comment', 'postId' => $post->id]]); ?>

                            <?= $form->field($newComment, 'text')->textarea(['rows' => 3, 'placeholder' => 'Текст комментария'])->label(false) ?>

                            <div class="form-group">
                                <?= \yii\helpers\Html::submitButton('Добавить комментарий', ['class' => 'btn btn-info']) ?>
                            </div>

                            <?php \yii\widgets\ActiveForm::end(); ?>
                        </div>
                    </div>
                </li>
            <?php } else { ?>
                    <li>
                        <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                        <div class="timeline-panel">
                            <div class="timeline-body">
                                <p>
                                    <b> Войдите в систему, чтобы оставлять комментарии. </b>
                                </p>
                            </div>
                        </div>
                    </li>
                <?php } ?>

            <?php foreach ($post->comments as $comment) { ?>
                <li>
                    <div class="timeline-badge"><i class="glyphicon glyphicon-check"></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title"><?= $comment->user->username ?></h4>
                            <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?= $comment->created_at ?> </small></p>
                        </div>
                        <div class="timeline-body">
                            <p>
                                <?= $comment->text ?>
                            </p>
                        </div>
                    </div>
                </li>
            <? } ?>


        </ul>

    </div>

</main>
