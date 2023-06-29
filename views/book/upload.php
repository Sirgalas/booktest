<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var app\Entities\Book\Entity\Book $book */
/** @var app\Entities\File\Form\UploadForm $model */

$this->title = 'Upload image from Book: ' . $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $book->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = 'Upload';
?>
<div class="book-upload">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->fileInput(['accept' => 'image/*']) ?>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
