<?php

namespace Igorw\Ilias\Form;

use Igorw\Ilias\Environment;

class SymbolForm implements Form
{
    private $symbol;

    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    public function evaluate(Environment $env)
    {
        return $env[$this->symbol];
    }

    public function getAst()
    {
        return $this->symbol;
    }
}
