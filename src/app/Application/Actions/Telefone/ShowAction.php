<?php

namespace App\Application\Actions\Telefone;

use App\Domain\Repositories\TelefoneRepositoryInterface;

class ShowAction
{
    protected TelefoneRepositoryInterface $repository;

    public function __construct(TelefoneRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $uuid): ?string
    {
        return $this->repository->find($uuid);
    }

}
