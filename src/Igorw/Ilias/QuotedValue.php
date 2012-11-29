<?php

namespace Igorw\Ilias;

class QuotedValue
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }
}
