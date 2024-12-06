<?php

namespace App\Application\Actions\WhatsApp;

use App\Domain\Repositories\WebhookRepositoryInterface;


class VerifyAction
{
    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $hubMode, string $hubToken, string $hubChallenge ): array
    {
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN', '123456789');

        if ($hubMode === 'subscribe' && $hubToken === $verifyToken) {
            return ['data' => $hubChallenge, 'code' =>200];
        }

        return ['data' => 'Forbidden', 'code' => 403];

    }

}
