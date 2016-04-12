<?php

namespace Refear99\EasyRongcloud\Exceptions;

class ChatroomException extends BaseException
{
    /**
     * @var int
     */
    public $httpStatusCode = 500;

    /**
     * @var string
     */
    public $errorType = 'chatroom_exceptions';

    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
