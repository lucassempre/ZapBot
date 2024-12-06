<?php

namespace App\Application\Actions\WhatsApp;

use App\Domain\Repositories\WebhookRepositoryInterface;


class PayloadAction
{
    private WebhookRepositoryInterface $repository;
    public function __construct(WebhookRepositoryInterface $repository)
    {
       $this->repository = $repository;
    }

    public function execute(string $uuid): array
    {
        $webhook = $this->repository->find($uuid);
        $data = json_decode($webhook->payload, true);
        $message_type = data_get($data, 'entry.0.changes.0.value.messages.0.type');
        return [
            'uuid' => $webhook->uuid,
            'ask' => $message_type == 'text' ? data_get($data, 'entry.0.changes.0.value.messages.0.text.body') : null,
            'telefone' => data_get($data, 'entry.0.changes.0.value.messages.0.from'),
            'type' => $message_type,
        ];
    }

}
