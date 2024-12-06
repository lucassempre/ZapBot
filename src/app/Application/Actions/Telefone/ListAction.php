<?php

namespace App\Application\Actions\Telefone;

use App\Domain\Repositories\TelefoneRepositoryInterface;

class ListAction
{
    protected TelefoneRepositoryInterface $repository;

    public function __construct(TelefoneRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $page, int $limit): array
    {
        return $this->repository->page($page, $limit);
    }

}
