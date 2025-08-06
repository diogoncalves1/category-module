<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedDefaultCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct('Não tem permissão para criar uma categoria default.', 403);
    }
}