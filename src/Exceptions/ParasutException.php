<?php

namespace yedincisenol\Parasut\Exceptions;

use Throwable;

class ParasutException extends \Exception
{
    /**
     * ParasutException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if ($this->isJson($message)) {
            $responseArray = json_decode($message, true);
            $errorMessage = null;
            if (is_array($responseArray['errors'])) {
                foreach ($responseArray['errors'] as $error) {
                    if (is_array($error)) {
                        $errorMessage .= @$error['detail'];
                    } else {
                        $errorMessage = $error;
                    }
                }
            } else {
                $errorMessage = $message;
            }

            parent::__construct($errorMessage, $code, $previous);
        } else {
            parent::__construct($message, $code, $previous);
        }
    }

    /**
     * Is string a json?
     * @param $string
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}