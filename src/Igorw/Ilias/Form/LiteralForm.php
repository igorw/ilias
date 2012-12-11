<?php

namespace Igorw\Ilias\Form;

use Igorw\Ilias\Environment;

class LiteralForm implements Form
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function evaluate(Environment $env)
    {
        return $this->value;
    }

    public function getAst()
    {
        return $this->value;
    }
}
