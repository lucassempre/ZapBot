<?php

namespace App\Domain\Repositories;

use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function all(): Collection;
    public function find(string $uuid);
    public function create(array $data);
    public function update(string $uuid, array $data): bool;
    public function delete(string $uuid): bool;
}
