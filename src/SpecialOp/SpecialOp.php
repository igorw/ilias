<?php

namespace Igorw\Ilias\SpecialOp;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

interface SpecialOp
{
    public function evaluate(Environment $env, ListForm $args);
}
