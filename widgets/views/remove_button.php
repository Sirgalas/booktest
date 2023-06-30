<?php

use yii\bootstrap\Html;
/**
 * @var integer $author_id
 */

echo Html::a(
    'Unsubscribe author',
    ['/user/redact/remove-author', 'author_id' => $author_id],
    [
        'class' => 'btn btn-warning',
        'data' => ['method' => 'post']
    ]
)

?>
