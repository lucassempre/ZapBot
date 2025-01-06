<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\StatusRepositoryInterface;
use App\Infrastructure\Models\Thread;
use Carbon\Carbon;
use Exception;


class ThreadRepository extends BaseRepository implements StatusRepositoryInterface
{
    public function model(): string
    {
        return Thread::class;
    }

    public function openTelefone(string $numero): Thread|null
    {
        return $this->model
            ->where('created_at', '>=', Carbon::now()->subMinutes(115))
            ->whereHas('telefone', function ($query) use ($numero) {
                $query->where('numero', $numero);
            })->first();
    }

    public function createWithTelefone(string $numero, string $thread_id): void
    {
        $telefone = Telefone::where('numero', $numero)->first();
        if (!$telefone) {
            throw new Exception("Telefone com número {$numero} não encontrado.");
        }

        $this->create([
            'thread_id' => $thread_id,
            'telefone_uuid' => $telefone->uuid
        ]);
    }

}
