<?php

namespace app\Entities\Author\Form;

use app\Entities\Author\Entity\Author;
use yii\base\Model;

class AuthorForm extends Model
{

    public $name;
    public $surname;
    public $family;

    public function __construct(Author $author = null,$config = [])
    {
        parent::__construct($config);
        if($author) {
            $this->name = $author->name;
            $this->surname = $author->surname;
            $this->family = $author->family;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'family'], 'string', 'max' => 255],
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
            'surname' => 'Surname',
            'family' => 'Family',
        ];
    }
}