<?php

namespace Modules\Category\Exceptions;

use Exception;

class CannotDeleteDefaultCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('alerts.cannotDeleteDefaultCategoryException'), 403);
    }
}
