<?php

namespace App\Application\Actions\ChatGPT;

use App\Infrastructure\Repositories\ThreadRepository;
use Illuminate\Support\Facades\Http;

class AskAssistantAction
{
    protected $apiUrl;

    protected ThreadRepository $threadRepository;

    public function __construct(ThreadRepository $threadRepository,)
    {
        $this->threadRepository = $threadRepository;
        $this->apiUrl = 'https://api.openai.com/v1';
    }

    /**
     * @throws \Exception
     */
    public function execute(string $ask, string $telefone): array
    {
        $tread_id = $this->threadRepository->openTelefone($telefone)?->thread_id;
        if(!$tread_id) {
            $tread_id = $this->createThread();
            $this->threadRepository->createWithTelefone($telefone, $tread_id);
        }
        $message = $this->createMessage($ask, $tread_id);
        $run_id = $this->createRun(env('OPENAI_ASSISTANT_ID'), $tread_id);
        return [
            'message_id' => $message,
            'run_id' => $run_id,
            'tread_id' => $tread_id,
        ];
    }

    public function createThread(): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/threads')->throw();

        return data_get($response, 'id');
    }

    public function createMessage(string $mnessage, string $thread_id): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/threads/'.$thread_id.'/messages', [
            'role' => 'user',
            'content' => $mnessage
        ])->throw();

        return data_get($response, 'id');
    }

    public function createRun(string $assistant_id, string $thread_id): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/threads/'.$thread_id.'/runs', [
            'assistant_id' => $assistant_id
        ])->throw();

        return data_get($response, 'id');
    }

}
