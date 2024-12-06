<?php

namespace app\Application\Jobs;

use App\Application\Actions\WhatsApp\SendInvalidAction;
use App\Infrastructure\Repositories\StatusRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ReplyInvalidJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $retryAfter = 2;

    protected string $message;
    protected array $payload;

    public function __construct(array $payload, string $message)
    {
        $this->message = $message;
        $this->payload = $payload;
    }

    /**
     * Executa o job.
     *
     * @return void
     */
    public function handle(SendInvalidAction $action)
    {
        $action->execute($this->payload, $this->message);
    }


    public function failed(?Throwable $exception): void
    {
        (new StatusRepository())->create([
            'webhook_uuid' =>  data_get($this->payload, 'webhook_uid'),
            'status' => 'Invalido',
            'status_descricao' => json_encode([
                'error' => $exception->getMessage(),
                'detalhe' => $exception
            ]),
        ]);
    }
}
