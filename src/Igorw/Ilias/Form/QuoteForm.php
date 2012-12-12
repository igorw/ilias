<?php

namespace Igorw\Ilias\Form;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Ast\QuotedValue;

class QuoteForm implements Form
{
    private $quoted;

    public function __construct(QuotedValue $quoted)
    {
        $this->quoted = $quoted;
    }

    public function evaluate(Environment $env)
    {
        return $this->quoted->getValue();
    }

    public function getAst()
    {
        return $this->quoted;
    }
}
