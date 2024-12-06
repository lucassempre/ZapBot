<?php

namespace App\Application\Actions\Webhook;

use App\Domain\Repositories\WebhookRepositoryInterface;

class ListAction
{
    protected WebhookRepositoryInterface $repository;

    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $page, int $limit): array
    {
        return $this->repository->page($page, $limit);
    }

}
