<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;
use Igorw\Ilias\Form\QuoteForm;

class QuoteOp implements SpecialOp
{
    public function evaluate(Environment $env, ListForm $args)
    {
        list($value) = $args->getAst();
        return $value;
    }
}
