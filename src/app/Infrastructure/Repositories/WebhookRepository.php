<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\WebhookRepositoryInterface;
use App\Infrastructure\Models\Webhook;


class WebhookRepository extends BaseRepository implements WebhookRepositoryInterface
{
    public function model(): string
    {
        return Webhook::class;
    }

}
