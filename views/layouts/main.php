<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="#">
</head>
<body class="bg-sand">
<header>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-my p-0 paddig_mobile">
        <div class="container">
            <a class="navbar-brand" href="/">Блог</a>
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                <form action="/site/index" method="get" class="form-inline w-60 ml-auto">
                    <input class="form-control mr-sm-2  p-2" style="width: 80%" type="search" name="search" placeholder="Поиск по тегам..." aria-label="Search">
                    <input type="submit" class="btn btn-my btn-my-w bg-transparent p-2" value="Найти">
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
                    </li>


                    <?php
                    if (Yii::$app->user->isGuest) {
                        echo
                        '<li class="nav-item">
                                <a class="nav-link" href="/site/sign-up">Регистрация</a>
                            </li>'
                        .
                        '<li class="nav-item">
                                <a class="nav-link" href="/site/login">Вход</a>
                            </li>';
                    } else {
                        echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Профиль </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="/user/index">Мои посты</a>
                            <a class="dropdown-item" href="/user/create">Создать пост</a>';
                        if (Yii::$app->user->identity->role == User::ROLE_ADMIN) {
                            echo '<div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/admin/post/index">Все посты</a>
                                    <a class="dropdown-item" href="/admin/tag/index">Теги</a>
                                    <a class="dropdown-item" href="/admin/comment/index">Комментарии</a>
                                    <a class="dropdown-item" href="/admin/user/index">Пользователи</a>';
                        }
                        echo '<div class="dropdown-divider"></div>
                                <a class="dropdown-item">
                            ' . Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Выход (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout']
                        )
                        . Html::endForm()
                        . '</a></div>';
                    }
                    ?>


                </ul>
            </div>
        </div>
    </nav>

</header>

    <?= $content ?>
</div>
<?php $this->endBody() ?>

</body>

<footer class="text-center ">
    <p class="mb-2">©</p>
</footer>

</html>
<?php $this->endPage() ?>
