<?php

namespace App\Infrastructure\Repositories;


use App\Domain\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    abstract public function model(): string;

    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(string $uuid): ?Model
    {
        return $this->model->find($uuid);
    }

    public function create(array $data): Model
    {
        $data = array_merge($data, ['uuid' => Str::uuid()->toString()]);
        return $this->model->create($data);
    }

    public function update(string $uuid, array $data): bool
    {
        $record = $this->find($uuid);
        if ($record)
            return $record->update($data);
        return false;
    }

    public function delete(string $uuid): bool
    {
        $record = $this->find($uuid);
        if ($record)
            return $record->delete();
        return false;
    }
}
