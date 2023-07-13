<?php

use app\Entities\Author\Entity\Author;
use app\Entities\User\Entity\PermissionEnum;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;


/** @var yii\web\View $this */
/** @var app\Entities\User\Entity\User $model */

$this->title = $model->username;
if(Yii::$app->user->can(PermissionEnum::ADMIN)) {
    $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-view">

    <?php if(!empty($model->messagesView)): ?>

        <?php foreach ($model->messagesView as $message): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close message-author-delete" data-dismiss="alert" aria-label="Close" data-id="<?= $message->id?>"><span aria-hidden="true">&times;</span></button>
                <?= $message->message ?>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'phone',
            'email:email',
            'created_at:date',
            'updated_at:date',
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
                'template' => '{remove-author}',
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
