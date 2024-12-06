<?php

namespace App\Application\Actions\Webhook;

use App\Domain\Repositories\WebhookRepositoryInterface;

class StatusAction
{
    protected WebhookRepositoryInterface $repository;

    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $status): array
    {
        return $this->repository->findByStatus($status);
    }

}
