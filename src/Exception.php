<?php


namespace Parser;


class Exception extends \Exception
{
    const E_ANY = -1;
    const E_UNKNOWN_OPTION = 1;
    const E_OPTION_PARAM_REQUIRED = 2;
    const E_OPTION_PARAM_NOT_VALID = 3;

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        if (!$code) {
            $code = self::E_ANY;
        }
        parent::__construct($message, $code, $previous);
    }
}