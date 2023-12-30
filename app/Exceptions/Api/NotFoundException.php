<?php

namespace App\Exceptions\Api;

use Exception;

class NotFoundException extends Exception
{
    const ERROR_MESSAGE = 'This resource is not found!';

    protected $statusCode;
    protected $errorMessage;

    public function __construct($code = 0, Exception $previous = null)
    {
        $this->statusCode = 404;
        $this->errorMessage = self::ERROR_MESSAGE;

        parent::__construct(self::ERROR_MESSAGE, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'status_code' => $this->statusCode,
            'message' => $this->errorMessage,
        ], $this->statusCode);
    }
}
