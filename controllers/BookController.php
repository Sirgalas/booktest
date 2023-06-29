<?php

namespace app\controllers;

use app\Entities\Book\Entity\Book;
use app\Entities\Book\Entity\BookSearch;
use app\Entities\Book\Form\BookForm;
use app\Entities\Book\Services\BookService;
use app\Entities\User\Entity\PermissionEnum;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    private $service;

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

    public function __construct($id, $module, BookService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function actionIndex()
    {
        $searchModel = new BookSearch();
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
        $form = new BookForm();

        if ($this->request->isPost) {
            if ($form->load($this->request->post()) && $form->validate()) {
                try{
                    $book = $this->service->create($form);
                    return $this->redirect(['view', 'id' => $book->id]);
                } catch (\RuntimeException $e) {
                    Yii::error($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->service->repository->one($id);
        $form = new BookForm($model);

        if ($this->request->isPost && $form->load($this->request->post()) && $form->validate()) {
            try{
                $this->service->edit($form,$model);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\RuntimeException $e) {
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