<?php

namespace App\Application\Actions\Message;

use App\Domain\Repositories\MessageRepositoryInterface;

class ListAction
{
    protected MessageRepositoryInterface $repository;

    public function __construct(MessageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $page, int $limit): array
    {
        return $this->repository->page($page, $limit);
    }

}
