<?php

namespace Refear99\EasyRongcloud\Exceptions;

class MessageException extends BaseException
{
    /**
     * @var int
     */
    public $httpStatusCode = 500;

    /**
     * @var string
     */
    public $errorType = 'message_exceptions';

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
