<?php

use app\Entities\User\Entity\PermissionEnum;
use app\widgets\AuthorButtonWidget;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\Entities\Author\Entity\Author $model */
/** @var \app\Entities\User\Entity\User $user */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="author-view">

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

    <?php endif; ?>
    <?= AuthorButtonWidget::widget(['user' => $user, 'author_id' => $model->id]); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'surname',
            'family',
        ],
    ]) ?>

</div>
