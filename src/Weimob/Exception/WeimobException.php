<?php
namespace Kiduc\Weimob\Exception;

class WeimobException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
