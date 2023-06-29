<?php

namespace app\Entities\File\Form;

use yii\base\Model;

class UploadForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [
                ['file'],
                'image',
                'skipOnEmpty' => false,
                'minWidth' => 400,
                'maxWidth' => 800,
                'minHeight' => 400,
                'maxHeight' => 800,
                'maxSize' => 1024*1024*3
            ],
        ];
    }
}