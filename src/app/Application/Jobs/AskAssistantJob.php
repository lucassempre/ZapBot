<?php

namespace App\Application\Jobs;

use App\Application\Actions\ChatGPT\AskAssistantAction;
use App\Infrastructure\Repositories\StatusRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;
use Mockery\Exception;
use Throwable;

class AskAssistantJob implements ShouldQueue
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
    public function handle(AskAssistantAction $action)
    {
        $ask = $action->execute(data_get($this->payload,'ask'), data_get($this->payload, 'telefone'));
        if(!empty($ask)) {
            Queue::pushOn(
                'app_01_alta',
                new RetriveAssistantJob(
                    data_get($ask, 'message_id'),
                    data_get($ask, 'run_id'),
                    data_get($ask, 'tread_id'),
                    data_get($this->payload, 'telefone'),
                    data_get($this->payload, 'uuid'),
                ));
        }
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
