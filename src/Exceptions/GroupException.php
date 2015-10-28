<?php

namespace Refear99\EasyRongcloud\Exceptions;

class GroupException extends BaseException
{
    /**
     * @var int
     */
    public $httpStatusCode = 500;

    /**
     * @var string
     */
    public $errorType = 'group_exceptions';

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
