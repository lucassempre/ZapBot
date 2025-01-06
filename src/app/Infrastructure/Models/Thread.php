<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Thread extends Model
{
    use SoftDeletes;

    protected $table = 'thread';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'webhook_uuid',
        'telefone_uuid',
        'thread_id',
    ];

    /**
     * Relacionamento: Thread pertence a Webhook.
     */
    public function webhook()
    {
        return $this->belongsTo(Webhook::class, 'webhook_uuid', 'uuid');
    }

    /**
     * Relacionamento: Thread pertence a telefone.
     */
    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_uuid', 'uuid');
    }
}
