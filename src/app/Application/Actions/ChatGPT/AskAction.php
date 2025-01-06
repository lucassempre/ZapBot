<?php

namespace App\Application\Actions\ChatGPT;

use Illuminate\Support\Facades\Http;

class AskAction
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://api.openai.com/v1/chat/completions';
    }

    public function execute(string $ask): string
    {
        return $this->askChatGPT($ask);
    }

    public function askChatGPT(string $question): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(300)->post($this->apiUrl, [
            'model' => 'ft:gpt-3.5-turbo-0125:personal::AYwVPgBC',
            'messages' => [
                ['role' => 'system', 'content' => 'Você é um assistente útil.'],
                ['role' => 'user', 'content' => $question],
            ],
            'max_tokens' => 150,
            'temperature' => 0.7,
        ])->throw();

        return data_get($response->json(), 'choices.0.message.content', 'Sem resposta');
    }

    public function askAssistantGPT()
    {
        $message = $messageRepository->create([
            'telefone_uuid' => $telefone->uuid,
            'resposta' => $message,
        ]);
    }

}
