<?php

namespace App\Application\Actions\Validate;

use App\Application\Actions\Telefone\ValidoAction;

class ValidAction
{
    protected ValidoAction $action;

    public function __construct(ValidoAction $action)
    {
        $this->action = $action;
    }

    public function execute(array $payload): ?string
    {
        if(!$this->action->execute(data_get($payload,'telefone')))
            return 'Sem permissão para consultar IA';

        if(data_get($payload,'type') != 'text')
            return 'Aplicação suporta apenas mensagens de texto';

        return null;
    }

}
