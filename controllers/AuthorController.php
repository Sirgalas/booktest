<?php

namespace app\controllers;


use app\Entities\Author\Entity\AuthorSearch;
use app\Entities\Author\Form\AuthorForm;
use app\Entities\Author\Services\AuthorService;
use app\Entities\User\Entity\PermissionEnum;
use PHPUnit\TextUI\RuntimeException;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthorController implements the CRUD actions for Author model.
 */
class AuthorController extends Controller
{
    private AuthorService $service;

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            ['access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [PermissionEnum::GUEST]
                    ],
                    [
                        'actions' => ['create','edit','delete'],
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

    public function __construct($id, $module, AuthorService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->service->repository->one($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new AuthorForm();

        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->validate()) {
                try {
                    $author = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $author->id]);
                } catch (RuntimeException $e) {
                    Yii::error($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * Updates an existing Author model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new AuthorForm($model);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->save()) {
            try {
                $this->service->edit($form,$model);
                return $this->redirect(['view', 'id' => $form->id]);
            } catch (RuntimeException $e) {
                Yii::error($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->repository->remove($id);

        return $this->redirect(['index']);
    }

}
