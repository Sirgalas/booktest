<?php

namespace app\Entities\Book\Form;

use app\Entities\Author\Entity\Author;
use yii\base\Model;

class AuthorsBookForm extends Model
{
    public $author_id;

    public function rules()
    {
        return [
            [
                ['author_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Author::class,
                'targetAttribute' => ['file_id' => 'id']
            ],
        ];
    }
}