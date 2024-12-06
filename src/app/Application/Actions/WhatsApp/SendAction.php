<?php

namespace App\Application\Actions\WhatsApp;

use App\Domain\Repositories\WebhookRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SendAction
{
    private WebhookRepositoryInterface $repository;

    public function __construct(WebhookRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid)
    {
        $webhook = $this->repository->find($uuid);
        $this->sendWhatsAppMessage($webhook->message->telefone->numero, $webhook->message->resposta);
    }
    private function sendWhatsAppMessage($to, $message)
    {
        $token = 'Bearer ' .env('WHATSAPP_API_TOKEN', '');
        $phone_number_id = env('WHATSAPP_PHONE_NUMBER_ID', '499352646595130');

        $url = "https://graph.facebook.com/v21.0/{$phone_number_id}/messages";

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'text',
            'text' => [
                'body' => $message,
            ],
        ];
        $response = Http::withHeaders([
            'Authorization' => $token,
            'Accept' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return true;
        } else {
            // Lidar com erros
            Log::error('Erro ao enviar mensagem WhatsApp', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
    }

}
