<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TelefoneRepositoryInterface;
use App\Infrastructure\Models\Telefone;
use Illuminate\Database\Eloquent\Model;


class TelefoneRepository extends BaseRepository implements TelefoneRepositoryInterface
{
    public function model(): string
    {
        return Telefone::class;
    }

    public function numero(string $numero): ?Model
    {
        return $this->model->where(['numero' => $numero])->first();
    }

    public function count(string $numero): int
    {
        return $this->model->where('numero', $numero)->count();
    }

}
