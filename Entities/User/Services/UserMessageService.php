<?php

declare(strict_types=1);

namespace app\Entities\User\Services;

use app\Entities\User\Repositories\UserMessageRepository;

class UserMessageService
{
    public $repository;

    public function __construct(UserMessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function userIsVisible($id): void
    {
        $message = $this->repository->one($id);
        $message->is_view = true;
        $this->repository->save($message);
    }
}