<?php

use App\Infrastructure\Controllers\{BoletoController, WebhookController};
use Illuminate\Support\Facades\Route;


Route::post('/webhook', [WebhookController::class, 'salvar']);
Route::get('/webhook', [WebhookController::class, 'verify']);
Route::get('/webhook/all', [WebhookController::class, 'list']);
Route::get('/webhook/{uuid}', [WebhookController::class, 'show']);
Route::get('/webhook/status/{status}', [WebhookController::class, 'status']);


Route::get('/message/', [BoletoController::class, 'list']);
Route::get('/message/{uuid}', [BoletoController::class, 'show']);
Route::get('/message/status/{status}', [BoletoController::class, 'status']);

Route::post('/telefone', [BoletoController::class, 'creat']);
Route::get('/telefone', [BoletoController::class, 'list']);
Route::get('/telefone/{uuid}', [BoletoController::class, 'show']);
Route::get('/telefone/{uuid}/message', [BoletoController::class, 'message']);
Route::get('/telefone/{uuid}/webhook', [BoletoController::class, 'webhook']);

