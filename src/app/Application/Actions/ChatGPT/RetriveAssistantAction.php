<?php

namespace App\Application\Actions\ChatGPT;

use App\Domain\Repositories\TelefoneRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Http;

class RetriveAssistantAction
{
    protected $apiUrl;

    protected TelefoneRepositoryInterface $telefoneRepository;

    public function __construct(TelefoneRepositoryInterface $telefoneRepository,)
    {
        $this->telefoneRepository = $telefoneRepository;
        $this->apiUrl = 'https://api.openai.com/v1';
    }

    public function execute(string $thread_id, string $run_id, string $message_id): string
    {
       $run_response = $this->retriveRun($thread_id, $run_id);
       if(data_get($run_response, 'status') != 'completed')
           throw new Exception("Run falhou: " . (data_get($run_response,'last_error.message') ?? 'Erro desconhecido'));

       return data_get($this->retriveMessage($thread_id, $message_id),'data.0.content.0.text.value');
    }

    public function retriveRun(string $thread_id, string $run_id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ])->get($this->apiUrl . '/threads/'.$thread_id.'/runs/'.$run_id)->throw();

        return $response->json();
    }

    public function retriveMessage(string $thread_id, string $message_id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'OpenAI-Beta' => 'assistants=v2',
            'Content-Type' => 'application/json',
        ])->get($this->apiUrl . '/threads/'.$thread_id.'/messages')->throw();

        return $response->json();
    }

}
