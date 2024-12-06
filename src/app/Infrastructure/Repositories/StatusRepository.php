<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\StatusRepositoryInterface;
use App\Infrastructure\Models\Status;


class StatusRepository extends BaseRepository implements StatusRepositoryInterface
{
    public function model(): string
    {
        return Status::class;
    }

}
