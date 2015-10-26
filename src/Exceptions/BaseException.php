<?php

namespace Refear99\EasyRongcloud\Exceptions;

class BaseException extends \Exception
{
    /**
     * @var int
     */
    public $httpStatusCode = 500;

    /**
     * @var string
     */
    public $errorType = 'base_exceptions';

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
