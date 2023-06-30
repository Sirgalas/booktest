<?php

namespace app\Entities\User\Services;

use app\Entities\Author\Repositories\AuthorRepository;
use app\Entities\User\Forms\LoginForm;
use app\Entities\User\Entity\User;
use app\Entities\User\Forms\SignupForm;
use app\Entities\User\Forms\UserRoleForm;
use app\Entities\User\Repositories\UserRepository;
use Yii;

class UserService
{
    public $repository;
    private $authorRepository;

    public function __construct(UserRepository $repository, AuthorRepository $authorRepository)
    {
        $this->repository = $repository;
        $this->authorRepository = $authorRepository;
    }

    public function signup(SignupForm $signupForm):User
    {
        $user=User::create(
            $signupForm->username,
            $signupForm->email,
            $signupForm->password,
            $signupForm->phone
        );
        $user->save($user);

        $auth = Yii::$app->authManager;
        $authorRole = $auth->getRole(User::GUEST);
        $auth->assign($authorRole, $user->getId());

        return $user;
    }

    public function auth(LoginForm $form): User
    {
        $user = User::findByUsername($form->email);
        if(!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        return $user;
    }

    public function redactRole(UserRoleForm $form, User $user): void
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($form->role);
        $auth->assign($role, $user->id);
    }

    public function addAuthor(int $author_id, User $user) {
        $author = $this->authorRepository->one($author_id);
        $user->addAuthors($author);
        $this->repository->save($user);
    }

    public function removeAuthor(int $author_id, User $user) {
        $user->removeAuthor($author_id);
        $this->repository->save($user);
    }

}