<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Status extends Model
{
    use SoftDeletes;

    protected $table = 'status';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'webhook_uuid',
        'status',
        'status_descricao',
    ];

    /**
     * Relacionamento: Status pertence a Webhook.
     */
    public function webhook()
    {
        return $this->belongsTo(Webhook::class, 'webhook_uuid', 'uuid');
    }
}
