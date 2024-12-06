<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Webhook extends Model
{
    use SoftDeletes;

    protected $table = 'webhook';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'message_uuid',
        'status_uuid',
        'telefone_uuid',
        'status_uuid',
        'payload',

    ];

    public function status()
    {
        return $this->hasMany(Status::class, 'webhook_uuid', 'uuid');
    }

    /**
     * Relacionamento: webhook possui muitos Boletos.
     */
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_uuid', 'uuid');
    }
}
