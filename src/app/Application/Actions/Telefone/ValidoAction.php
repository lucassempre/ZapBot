<?php

namespace App\Application\Actions\Telefone;

use App\Domain\Repositories\TelefoneRepositoryInterface;

class ValidoAction
{
    protected TelefoneRepositoryInterface $repository;

    public function __construct(TelefoneRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): bool
    {
        return $this->repository->count($uuid);
    }

}
