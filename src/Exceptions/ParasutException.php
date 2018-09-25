<?php

namespace yedincisenol\Parasut\Exceptions;

use Throwable;

class ParasutException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($this->isJson($message)) {
            $responseArray = json_decode($message, true);
            $errorMessage = null;
            if (is_array($responseArray['errors'])) {
                foreach ($responseArray['errors'] as $error) {
                    $errorMessage .= $error['detail'];
                }
            } else {
                $errorMessage = $message;
            }

            parent::__construct($errorMessage, $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}