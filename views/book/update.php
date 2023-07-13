<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \app\Entities\Book\Form\BookForm $model */
/** @var \app\Entities\Book\Entity\Book $book */

$this->title = 'Update Book: ' . $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $book->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
