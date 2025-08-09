<?php

namespace App\Exceptions;

use Exception;

class CannotDeleteOthersCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct('Não tem permissões para apagar a categoria de outro utilizador', 403);
    }
}
