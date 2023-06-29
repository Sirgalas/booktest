<?php

namespace app\Entities\BookAuthor\Repositories;


use app\Entities\Author\Entity\BookAuthor;
use app\Helpers\RequestHelper;
use RuntimeException;

class BookBookAuthorRepository
{
    public function one(int $id): BookAuthor
    {
        if(!$BookAuthor = BookAuthor::findOne($id)) {
            throw new RuntimeException("BookAuthor not find");
        }
        return $BookAuthor;
    }

    public function find(int $id):? BookAuthor
    {
        if(!$BookAuthor = BookAuthor::findOne($id)) {
            return null;
        }
        return $BookAuthor;
    }

    public function oneByAuthorAndBook(int $authorId, int $bookId): BookAuthor
    {
        if(!$BookAuthor = BookAuthor::findOne(["author_id" => $authorId, "book_id" => $bookId])) {
            throw new RuntimeException("BookAuthor not find");
        }
        return $BookAuthor;
    }



    public function findByAuthorAndBook(int $authorId, int $bookId):? BookAuthor
    {
        if(!$BookAuthor = BookAuthor::findOne(["author_id" => $authorId, "book_id" => $bookId])) {
            return null;
        }
        return $BookAuthor;
    }

    public function save(BookAuthor $BookAuthor): BookAuthor
    {
        if(!$BookAuthor->save()){
            throw  new RuntimeException(RequestHelper::errorsToStr($BookAuthor->errors));
        }
        return $BookAuthor;
    }

    public function remove(int $id): void
    {
        $BookAuthor = $this->one($id);
        $BookAuthor->delete();
    }
}