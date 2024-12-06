<?php

namespace App\Application\Actions\Webhook;

use App\Application\Jobs\ProcessJob;
use App\Domain\Repositories\WebhookRepositoryInterface;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\HttpFoundation\InputBag;

class CriarAction
{
    protected WebhookRepositoryInterface $repository;

    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $json)
    {
        $webhook = $this->repository->create([
            'payload' => json_encode($json)
        ]);
        Queue::pushOn('app_01_alta', new ProcessJob($webhook->uuid));
    }

}
