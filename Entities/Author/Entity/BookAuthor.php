<?php

namespace app\Entities\Author\Entity;

use app\Entities\Author\Form\BookAuthorForm;
use app\Entities\Book\Entity\Book;
use app\Queue\MessageJob;
use app\Senders\FlashSend;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "book_author".
 *
 * @property int $book_id
 * @property int $author_id
 *
 * @property Author $author
 * @property Book $book
 */
class BookAuthor extends \yii\db\ActiveRecord
{

    public static function create(BookAuthorForm $form): self
    {
        $bookAuthor = new static();
        $bookAuthor->book_id = $form->book_id;
        $bookAuthor->author_id = $form->author_id;
        return $bookAuthor;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author';
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    public function getBook(): ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

}
