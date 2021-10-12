<?php


namespace Kiduc\Weimob\Exception;


class ValidationException extends WeimobException
{
    public $errors;
    public function __construct($message, array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }
}
