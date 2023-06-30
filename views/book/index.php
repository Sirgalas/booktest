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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function(Book $book) {
                    if(is_object($book->file)) {
                        return Html::img($book->file->getUrl());
                    }
                    return null;
                }
            ],
            'title',
            'year',
            'isbn',
            [
                'class' => ActionColumn::class,
                'template' => HelperView::template(PermissionEnum::USER,'{update} {delete} {upload} '),
                'buttons' => [
                    'upload' => function ($url, $model) {
                        return Html::a(
                            '<span class="fas fa-image"></span>',
                            $url,
                            [
                                'class'       => 'dropdown-item'
                            ]
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
