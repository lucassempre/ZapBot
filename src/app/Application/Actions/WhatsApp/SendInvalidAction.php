<?php

namespace App\Application\Actions\WhatsApp;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendInvalidAction
{
    public function __construct()
    {
    }

    public function execute(array $payload, string $message)
    {
        $this->sendWhatsAppMessage(data_get($payload, 'telefone'), $message);
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

        $response = Http::withToken($token)->post($url, $data);

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
