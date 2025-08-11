<?php

namespace Modules\Category\Exceptions;

use Exception;

class UnauthorizedDefaultCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('alerts.unauthorizedDefaultCategoryException'), 403);
    }
}
