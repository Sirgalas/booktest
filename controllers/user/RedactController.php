<?php

namespace app\controllers\user;

use app\Entities\User\Entity\PermissionEnum;
use app\Entities\User\Entity\User;
use app\Entities\User\Entity\UserSearch;
use app\Entities\User\Forms\UserRoleForm;
use app\Entities\User\Services\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RedactController implements the CRUD actions for User model.
 */
class RedactController extends Controller
{

    private UserService $service;

    public function __construct($id, $module, UserService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['logout'],
                    'rules' => [
                        [
                            'actions' => ['view'],
                            'allow' => true,
                            'roles' => [PermissionEnum::GUEST]
                        ],
                        [
                            'actions' => ['index','edit'],
                            'allow' => true,
                            'roles' => [PermissionEnum::USER],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView()
    {
        return $this->render('view', [
            'model' => $this->service->repository->one(\Yii::$app->user->identity->id),
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->service->repository->one($id);
        $form = new UserRoleForm($model);
        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            $this->service->redactRole($form,$model);
        }
        return $this->render('update', [
            'model' => $form,
            'user' =>$model
        ]);
    }

    public function actionAddAuthor(int $author_id)
    {

        if ($this->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $user = $this->service->repository->one(Yii::$app->user->id);
                $this->service->addAuthor($author_id, $user);
                $transaction->commit();
            } catch (\RuntimeException $e) {
                Yii::error($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
                $transaction->rollBack();
            }
        }
        return $this->redirect(["/author/view", 'id' => $author_id]);
    }

    public function actionRemoveAuthor(int $author_id)
    {

        if ($this->request->isPost){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $user = $this->service->repository->one(Yii::$app->user->id);
                $this->service->removeAuthor($author_id, $user);
                $transaction->commit();
            } catch (\RuntimeException $e) {
                Yii::error($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
                $transaction->rollBack();
            }
        }
        return $this->redirect(["/author/view", 'id' => $author_id]);
    }
}
