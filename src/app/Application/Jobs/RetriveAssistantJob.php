<?php

namespace App\Application\Jobs;

use App\Application\Actions\ChatGPT\RetriveAssistantAction;
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

class RetriveAssistantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $tries = 3;
    protected string $message_id;
    protected string $run_id;
    protected string $tread_id;
    protected string $telefone;
    protected string $webhook_uuid;

    public function __construct(string $message_id, string $run_id, string $tread_id, string $telefone, string $webhook_uuid)
    {
        $this->message_id = $message_id;
        $this->run_id = $run_id;
        $this->tread_id = $tread_id;
        $this->telefone = $telefone;
        $this->webhook_uuid = $webhook_uuid;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(RetriveAssistantAction $action, TelefoneRepository $telefoneRepository, MessageRepository $messageRepository, WebhookRepository $webhookRepository)
    {
        $message = $action->execute($this->tread_id, $this->run_id, $this->message_id);

        $telefone = $telefoneRepository->numero($this->telefone);

        $message = $messageRepository->create([
            'telefone_uuid' => $telefone->uuid,
            'resposta' => $message,
        ]);

        $webhookRepository->update($this->webhook_uuid, [
            'message_uuid' => $message->uuid,
        ]);

        Queue::pushOn('app_01_alta', new ReplyJob($this->webhook_uuid));
    }

    public function failed(?Throwable $exception): void
    {
        (new StatusRepository())->create([
            'webhook_uuid' => $this->webhook_uuid,
            'status' => 'Invalido',
            'status_descricao' => json_encode([
                'error' => $exception->getMessage(),
                'detalhe' => $exception
            ]),
        ]);
    }

    public function backoff()
    {
        return [1, 2, 3];
    }
}
