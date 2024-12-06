<?php

namespace App\Application\Actions\Webhook;

use App\Domain\Repositories\WebhookRepositoryInterface;

class ShowAction
{
    protected WebhookRepositoryInterface $repository;

    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): ?string
    {
        return $this->repository->find($uuid);
    }

}
