<?php

namespace App\Application\Jobs;

use App\Application\Actions\WhatsApp\SendAction;
use App\Infrastructure\Repositories\StatusRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ReplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $retryAfter = 2;

    protected string $webhook_uuid;

    public function __construct(string $webhook_uuid)
    {
        $this->webhook_uuid = $webhook_uuid;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(SendAction $action)
    {
        $action->execute($this->webhook_uuid);
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
}
