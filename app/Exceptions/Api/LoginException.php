<?php

namespace App\Exceptions\Api;

use Exception;

class LoginException extends Exception
{
    protected $statusCode;
    protected $errorMessage;

    public function __construct($statusCode, $errorMessage, $code = 0, Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->errorMessage = $errorMessage;

        parent::__construct($errorMessage, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            'status_code' => $this->statusCode,
            'message' => $this->errorMessage,
        ], $this->statusCode);
    }
}
