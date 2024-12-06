<?php

namespace App\Application\Actions\Message;

use App\Domain\Repositories\MessageRepositoryInterface;

class StatusAction
{
    protected MessageRepositoryInterface $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $status): array
    {
        return $this->repository->findByStatus($status);
    }

}
