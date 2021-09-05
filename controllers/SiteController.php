<?php

namespace app\controllers;

use app\models\Comment;
use app\models\SignUpForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Post;
use app\models\Tag;
use app\models\TagList;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($search = null)
    {
        $tags = Tag::find()->all();
        if ($search == null) {
            $posts = Post::find()->orderBy('id DESC')->all();
        }
        else {
            $tag = Tag::findOne(['title' => $search]);
            $tagList = TagList::findAll(['tag_id' => $tag->id]);
            $posts = [];
            foreach ($tagList as $list) {
                $post = Post::findOne($list->post_id);
                array_push($posts, $post);
            }

            array_multisort($posts, SORT_DESC);

            if ($posts == null) {
                echo Yii::$app->session->setFlash('danger', 'По вашему запросу ничего не найдено');
            }
        }

        return $this->render('index', [
            'posts' => $posts,
            'tags' => $tags
        ]);
    }

    /**
     * Страница отдельного поста
     *
     * @return string
     */
    public function actionView($id)
    {
        $post = Post::findOne($id);
        $tags = TagList::findAll(['post_id' => $id]);
        $newComment = new Comment();

        return $this->render('view', [
            'post' => $post,
            'tags' => $tags,
            'newComment' => $newComment,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/user/index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/user/index');
            // return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignUp()
    {
        $model = new SignUpForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            echo Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!');
            return $this->redirect('login');
        }
        return $this->render('sign-up', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Добавление комментария
     * @param $postId
     * @return Response
     */
    public function actionAddComment($postId)
    {
        $model = new Comment();
        if ($model->load(Yii::$app->request->post())) {
            $model->post_id = $postId;
            $model->user_id = Yii::$app->user->identity->id;
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();
            echo Yii::$app->session->setFlash('success', 'Комментарий добавлен!');
        }
        return $this->redirect(['view', 'id' => $postId]);
    }
}
