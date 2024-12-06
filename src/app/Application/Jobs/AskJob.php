<?php

namespace App\Application\Jobs;

use App\Application\Actions\ChatGPT\AskAction;
use App\Infrastructure\Repositories\MessageRepository;
use App\Infrastructure\Repositories\StatusRepository;
use App\Infrastructure\Repositories\TelefoneRepository;
use App\Infrastructure\Repositories\WebhookRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;
use Throwable;

class AskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    protected array $payload;

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(AskAction $action, MessageRepository $messageRepository,
                           TelefoneRepository $telefoneRepository, WebhookRepository $webhookRepository)
    {
        $message = $action->execute(data_get($this->payload,'ask'));
        $telefone = $telefoneRepository->numero(data_get($this->payload, 'telefone'));
        $message = $messageRepository->create([
            'telefone_uuid' => $telefone->uuid,
            'resposta' => $message,
        ]);
        $webhookRepository->update(data_get($this->payload, 'uuid'), [
            'message_uuid' => $message->uuid,
        ]);
    }

    public function failed(?Throwable $exception): void
    {
        (new StatusRepository())->create([
            'webhook_uuid' =>  data_get($this->payload, 'uuid'),
            'status' => 'Invalido',
            'status_descricao' => json_encode([
                'error' => $exception->getMessage(),
                'detalhe' => $exception
            ]),
        ]);
    }
}
