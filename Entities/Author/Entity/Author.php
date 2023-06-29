<?php

namespace app\Entities\Author\Entity;

use app\Entities\Author\Form\AuthorForm;
use app\Entities\Book\Entity\Book;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "author".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $family
 *
 * @property BookAuthor[] $bookAuthors
 * @property Book[] $books
 */
class Author extends \yii\db\ActiveRecord
{
    public static function create(AuthorForm $form):self
    {
        $author = new static();
        $author->name = $form->name;
        $author->surname = $form->surname;
        $author->family = $form->family;
        return $author;
    }

    public function edit(AuthorForm $form): void
    {
        $this->name = $form->name;
        $this->surname = $form->surname;
        $this->family = $form->family;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author';
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->via('bookAuthors');
    }

    public function getFullName(): string
    {
        return implode(" ",[$this->name,$this->surname,$this->family]);
    }

    public function isHasAuthor(int $id) {
        return $this->id == $id;
    }
}
