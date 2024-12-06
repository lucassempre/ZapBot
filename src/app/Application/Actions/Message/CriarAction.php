<?php

namespace App\Application\Actions\Message;

use App\Domain\Repositories\MessageRepositoryInterface;

class CriarAction
{
    protected MessageRepositoryInterface $repository;

    public function __construct(MessageRepositoryInterface $repository,)
    {
        $this->repository = $repository;
    }

    public function execute(string $processamento_uuid)
    {
        $this->repository->updateStatusByProcessamento($processamento_uuid, 'Boleto Gerado');
    }

}
