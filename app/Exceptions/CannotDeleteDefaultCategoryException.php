<?php

namespace App\Exceptions;

use Exception;

class CannotDeleteDefaultCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct('Não tem permissões para apagar uma categoria default.', 403);
    }
}
