<?php

namespace App\Application\Actions\Telefone;

use App\Domain\Repositories\TelefoneRepositoryInterface;

class CriarAction
{
    protected TelefoneRepositoryInterface $repository;

    public function __construct(TelefoneRepositoryInterface $repository,)
    {
        $this->repository = $repository;
    }

    public function execute(string $processamento_uuid)
    {
        $this->repository->updateStatusByProcessamento($processamento_uuid, 'Boleto Gerado');
    }

}
