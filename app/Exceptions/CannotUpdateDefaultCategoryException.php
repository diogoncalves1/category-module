<?php

namespace App\Exceptions;

use Exception;

class CannotUpdateDefaultCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('alerts.cannotUpdateDefaultCategoryException'), 403);
    }
}
