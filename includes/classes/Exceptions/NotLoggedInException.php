<?php

declare(strict_types=1);

namespace Bjercke\Exception;

use Exception;

class NotLoggedInException extends Exception {

    protected $message = 'No users are logged in.';

}