<?php

namespace Modules\Category\Exceptions;

use Exception;

class CannotUpdateOthersCategoryException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('alerts.cannotUpdateOthersCategoryException'), 403);
    }
}
