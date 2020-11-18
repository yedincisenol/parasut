<?php

namespace yedincisenol\Parasut\Exceptions;

use Exception;
use Throwable;

class ParasutException extends Exception
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
                    $errorMessage = $this->getErrorDetail($error);
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
     * @param $error
     * @return string|null
     */
    private function getErrorDetail($error)
    {
        $errorString = null;
        if (is_array($error)) {
            if (isset($error['detail'])) {
                $errorString .= $error['detail'];
            }

            if (isset($error['title'])) {
                $errorString .= ' ' . $error['title'];
            }
        } elseif (is_string($error)) {
            $errorString = $error;
        }

        return $errorString;
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