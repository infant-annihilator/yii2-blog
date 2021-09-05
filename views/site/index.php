<?php
use yii\helpers\Html;
$user = Yii::$app->user;
?>
<section class="home-blog">
    <div class="container">
        <!-- section title -->
        <div class="row justify-content-md-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="section-title text-center title-ex1">
                    <h2>Блог</h2>
                    <p>Добро пожаловать<?= $user->isGuest ?
                            '! Зарегистрируйтесь, чтобы оставлять посты.'
                            :
                            ", " . $user->identity->username ?>
                    </p>
                    <div class="tag">
                        <span>
                            <?php foreach ($tags as $tag) {
                                    echo "<a href='/site/index?search=$tag->title'><span> $tag->title </span></a>";
                                } ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- section title ends -->
        <div class="row ">

            <?php foreach ($posts as $post) { ?>


                <div class="col-md-6">
                    <div class="media blog-media">
                        <a href="/site/view?id=<?= $post->id ?>" target="_blank">
                            <img src="../post_images/<?= $post->img ?>" class="d-flex"
                                         ">
                        </a>
                        <div class="circle">
                            <h5 class="day"><?= $post->getDay() ?></h5>
                            <span class="month"><?= $post->getMonth() ?></span>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0 mb-0">
                                <?= Html::a($post->title, ['/site/view', 'id' => $post->id], ['target' => '_blank', 'class' => 'title']) ?>
                            </h5>

                            <?= $post->user->username ?>

                            <div class="tag">
                                <span>
                                    <?php foreach ($post->tagLists as $tag) {
                                            $tag = $tag->tag;
                                            echo "<a href='/site/index?search=$tag->title'><span> $tag->title </span></a>";
                                        }
                                    ?>
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
</section>