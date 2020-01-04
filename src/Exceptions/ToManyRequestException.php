<?php

namespace yedincisenol\Parasut\Exceptions;

class ToManyRequestException extends ParasutException
{
    /**
     * @return int|mixed
     */
    public function getSecondsForWait()
    {
        $error = $this->getMessage();
        preg_match('!\d+!', $error, $seconds);

        return $seconds ? $seconds[0] : 0;
    }
}