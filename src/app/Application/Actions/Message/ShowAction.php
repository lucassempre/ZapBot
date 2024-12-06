<?php

namespace App\Application\Actions\Message;

use App\Domain\Repositories\MessageRepositoryInterface;

class ShowAction
{
    protected MessageRepositoryInterface $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): ?string
    {
        return $this->repository->find($uuid);
    }

}
