<?php

use app\Entities\Author\Entity\Author;
use app\Entities\Book\Entity\Book;
use app\Entities\User\Entity\PermissionEnum;
use app\Helpers\HelperView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\Entities\Book\Entity\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->can(PermissionEnum::USER)): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('Add author',Url::to(['book/add-author', "id" => $model->id]), ['class' => 'btn btn-primary'])?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
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
            'description:ntext',
            'isbn',
        ],
    ]) ?>
    <?php if(!empty($model->authors)): ?>
        <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider(['query' => $model->getAuthors()]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'surname',
            'family',
            [
                'class' => ActionColumn::class,
                'template' => HelperView::template(PermissionEnum::USER,' {remove-author} '),
                'buttons' => [
                    'view' => function ($url, Author $author,$key) use ($model)  {
                        return Html::a(
                            '<i class="far fa-eye"></i>',
                            Url::to(["/author/view",'author_id'=>$author->id]),
                            ['data' => ['method' => 'post']]
                        );
                    },
                    'remove-author' => function ($url, Author $author,$key) use ($model)  {
                        return Html::a(
                            '<i class="fas fa-user-minus"></i>',
                            Url::to(["book/remove-author",'book_id'=>$model->id,'author_id'=>$author->id]),
                            ['data' => ['method' => 'post']]
                        );
                    },
                ],
            ]
        ],
    ]); ?>
    <?php endif; ?>

</div>
