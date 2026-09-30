<?php

namespace App\Exceptions;

use RuntimeException;
use Throwable;

class RecordNotFoundException extends RuntimeException
{
    public function __construct(string $message = 'The requested record was not found.', ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
