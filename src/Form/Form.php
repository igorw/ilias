<?php

namespace Igorw\Ilias\Form;

use Igorw\Ilias\Environment;

interface Form
{
    public function evaluate(Environment $env);
    public function getAst();
}
