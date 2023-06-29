<?php

namespace app\Entities\Book\Services;

use app\Entities\Book\Entity\Book;
use app\Entities\Book\Form\BookForm;
use app\Entities\Book\Repositories\BookRepository;

class BookService
{
    public $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BookForm $form): Book
    {
        $book = Book::create($form);
        return $this->repository->save($book);
    }

    public function edit(BookForm $form, Book $book): Book
    {
        $book->edit($form);
        return $this->repository->save($book);
    }
}