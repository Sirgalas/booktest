<?php
namespace app\controllers\user;

use app\Entities\User\Forms\LoginForm;
use app\Entities\User\Forms\SignupForm;
use app\Entities\User\Services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['signup','login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    private $userService;

    public function __construct($id, $module, UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }

    public function actionSignup() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $form = new SignupForm();
        if($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->userService->signup($form);
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            } catch (\DomainException $e){
                Yii::$app->session->setFlash('error',$e->getMessage());
            }
        }
        if($form->errors) {
            Yii::$app->session->setFlash('error','ошибка валидации');
        }
        return $this->render('signup', [
            'model' => $form,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
                $user = $this->userService->auth($form);
                Yii::$app->user->login($user, $form->rememberMe ? Yii::$app->params['rememberMeDuration'] : 0);
                $this->goBack();
            }catch(\DomainException $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
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

}