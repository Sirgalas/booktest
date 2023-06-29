<?php

use app\Entities\Book\Entity\Book;
use app\Entities\User\Entity\PermissionEnum;
use app\Helpers\HelperView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\Entities\Book\Entity\BookSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->can(PermissionEnum::USER)): ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            'year',
            'isbn',
            //'file_id',
            [
                'class' => ActionColumn::class,
                'template' => HelperView::template(PermissionEnum::USER,'{update} {delete} {history} {upload} {add-author}'),
                /*'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },*/
                'buttons' => [
                    'upload' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-image"></span>',
                            $url,
                            [
                                'class'       => 'dropdown-item',
                                'data-method' => 'post',
                            ]
                        );
                    },
                    'add-author' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="fas fa-user-plus"></span>',
                            $url,
                            [
                                'class'       => 'dropdown-item',
                                'data-method' => 'post',
                            ]
                        );
                    }
                ]
            ],
        ],
    ]); ?>


</div>
