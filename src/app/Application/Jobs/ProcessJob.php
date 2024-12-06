<?php

namespace App\Application\Jobs;

use App\Application\Actions\WhatsApp\PayloadAction;
use App\Infrastructure\Repositories\StatusRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Throwable;

class ProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $webhook_uuid;

    /**
     * Cria uma nova instância do job.
     *
     * @return void
     */
    public function __construct(string $webhook_uuid)
    {
        $this->webhook_uuid = $webhook_uuid;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(PayloadAction $action)
    {
        $payload = $action->execute($this->webhook_uuid);
        Bus::chain([
            new ValidateJob($payload),
            new AskJob($payload),
            new ReplyJob($this->webhook_uuid)
        ])->onQueue('app_01_alta')->dispatch();
    }

    public function failed(?Throwable $exception): void
    {
        (new StatusRepository())->create([
            'processamento_uuid' =>  $this->processamento->uuid,
            'status' => 'Invalido',
            'status_descricao' => json_encode([
                'error' => $exception->getMessage(),
                'detalhe' => $exception
            ]),
        ]);
    }
}
