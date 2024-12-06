<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Message extends Model
{
    use SoftDeletes;

    protected $table = 'message';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'webhook_uuid',
        'telefone_uuid',
        'status_uuid',
        'resposta',
    ];

    /**
     * Relacionamento: Message pertence a webhook.
     */
    public function webhook()
    {
        return $this->belongsTo(webhook::class, 'webhook_uuid', 'uuid');
    }

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_uuid', 'uuid');
    }
}
