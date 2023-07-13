<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\Entities\Author\Form\AuthorForm $model */
/** @var app\Entities\Author\Entity\Author $author */

$this->title = 'Update Author: ' . $author->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $author->name, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
