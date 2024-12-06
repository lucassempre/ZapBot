<?php

namespace App\Application\Jobs;

use App\Application\Actions\Validate\ValidAction;
use App\Infrastructure\Repositories\MessageRepository;
use App\Infrastructure\Repositories\StatusRepository;
use App\Infrastructure\Repositories\TelefoneRepository;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;
use Mockery\Exception;
use Throwable;

class ValidateJob implements ShouldQueue
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
    public function handle(ValidAction $action)
    {
        print_r($this->batch());
        $message = $action->execute($this->payload);
        if($message) {
            Queue::pushOn('app_01_alta', new ReplyInvalidJob($this->payload, $message));
            throw new Exception('Processamento invalidado');
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
