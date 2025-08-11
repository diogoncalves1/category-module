<?php

namespace Modules\Category\Exceptions;

use Exception;

class CannotDeleteOthersCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('alerts.cannotDeleteOthersCategoryException'), 403);
    }
}
