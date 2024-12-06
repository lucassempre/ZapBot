<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\MessageRepositoryInterface;
use App\Infrastructure\Models\Message;


class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function model(): string
    {
        return Message::class;
    }

}
