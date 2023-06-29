<?php

namespace app\Entities\File\Form;

use yii\base\Model;

class CreationForm extends Model
{
    public $id;

    public $name;

    public $extension;

    public $path;

    public $size;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'extension'], 'string', 'max' => 255],
            [['path'], 'string', 'max' => 512],
            [['size'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'extension' => 'Extension',
            'path' => 'Path',
            'size' => 'Size',
        ];
    }

}