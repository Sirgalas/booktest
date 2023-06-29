<?php

namespace app\Entities\Book\Services;

use app\Entities\Author\Repositories\AuthorRepository;
use app\Entities\Book\Entity\Book;
use app\Entities\Book\Form\AuthorsBookForm;
use app\Entities\Book\Form\BookForm;
use app\Entities\Book\Repositories\BookRepository;
use app\Entities\File\Form\UploadForm;

class BookService
{
    public $repository;
    public $authorRepository;

    public function __construct(BookRepository $repository, AuthorRepository $authorRepository)
    {
        $this->repository = $repository;
        $this->authorRepository = $authorRepository;
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

    public function upload(UploadForm $form, Book $book) {
        $book->addFile($form->file);
        $this->repository->save($book);
    }

    public function addAuthor(AuthorsBookForm $form, Book $book) {
        $author = $this->authorRepository->one($form->author_id);
        $book->addAuthors($author);
        $this->repository->save($book);
    }

    public function removeAuthor(int $author_id, Book $book) {
        $book->removeAuthor($author_id);
        $this->repository->save($book);
    }


}