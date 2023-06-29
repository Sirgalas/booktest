<?php

namespace app\Entities\Book\Repositories;

use app\Entities\Book\Entity\Book;
use app\Helpers\RequestHelper;
use Faker\Extension\Helper;
use \RuntimeException;

class BookRepository
{
    public function one(int $id): Book
    {
        if(!$book = Book::findOne($id)) {
            throw new RuntimeException("Book not find");
        }
        return $book;
    }

    public function find(int $id):? Book
    {
        if(!$book = Book::findOne($id)) {
            return null;
        }
        return $book;
    }


    public function save(Book $book): Book
    {
        if(!$book->save()){
            throw  new RuntimeException(RequestHelper::errorsToStr($book->errors));
        }
        return $book;
    }

    public function remove(int $id): void
    {
        $book = $this->one($id);
        $book->delete();
    }
}