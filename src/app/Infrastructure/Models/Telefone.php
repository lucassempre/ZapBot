<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefone extends Model
{
    use SoftDeletes;

    protected $table = 'telefone';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'numero',
    ];

    /**
     * Relacionamento: Telefone possui muitos webhook.
     */
    public function webhhook()
    {
        return $this->hasMany(Status::class, 'telefone_uuid', 'uuid');
    }

    /**
     * Relacionamento: Telefone possui muitas Message.
     */
    public function message()
    {
        return $this->hasMany(Message::class, 'telefone_uuid', 'uuid');
    }
}
