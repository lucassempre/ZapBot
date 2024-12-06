<?php

namespace App\Infrastructure\Controllers;

use App\Application\Actions\Webhook\CriarAction;
use App\Application\Actions\WhatsApp\VerifyAction;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Throwable;

class WebhookController extends BaseController
{
    public function salvar(Request $request, CriarAction $action)
    {
        Log::info(json_encode(['data' => $request->all()]));
        try {
            $action->execute($request->json()->all());
            return response()->json(['status' => 'success'], 200);
        } catch (Throwable $e) {
            Log::error('Erro ao salvar webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Falha ao salvar webhook'], 400);
        }
    }

    public function verify(Request $request, VerifyAction $action)
    {
        Log::info(json_encode(['data' => $request->all()]));
        try {
            $data = $action->execute(
                $request->get('hub_mode'),
                $request->get('hub_verify_token'),
                $request->get('hub_challenge')
            );
            Log::info(response()->json((int) data_get($data, 'data'), data_get($data, 'code')));
            return response()->json((int) data_get($data, 'data'), data_get($data, 'code'));
        } catch (Throwable $e) {
            Log::error('Erro ao salvar webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Falha ao salvar webhook'], 400);
        }
    }

    public function list(Request $request, CriarAction $action)
    {
        try {
            print_r(gettype($request->json()->all()));
            $action->execute($request->json()->all());
            return response()->json(['status' => 'success'], 200);
        } catch (Throwable $e) {
            Log::error('Erro ao salvar webhook: ' . $e->getMessage());
            return response()->json(['message' => 'Falha ao salvar webhook'], 400);
        }
    }
}
