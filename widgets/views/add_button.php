<?php

use yii\bootstrap\Html;
/**
 * @var integer $author_id
 */

echo Html::a(
    'Subscribe author',
    ['/user/redact/add-author', 'author_id' => $author_id],
    [
        'class' => 'btn btn-success',
        'data' => ['method' => 'post']
    ])

?>
