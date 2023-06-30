<?php

namespace app\Entities\Author\Services;

use app\Entities\Author\Entity\Author;
use app\Entities\Author\Form\AuthorForm;
use app\Entities\Author\Repositories\AuthorRepository;
use app\Entities\User\Repositories\UserRepository;

class AuthorService
{
    public $repository;
    public UserRepository $userRepository;

    public function __construct(AuthorRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function create(AuthorForm $form): Author
    {
        $author = Author::create($form);
        return $this->repository->save($author);
    }

    public function edit(AuthorForm $form, Author $author): Author
    {
        $author->edit($form);
        return $this->repository->save($author);
    }
}
