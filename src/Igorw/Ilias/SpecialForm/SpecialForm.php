<?php

namespace Igorw\Ilias\SpecialForm;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

interface SpecialForm
{
    public function evaluate(Environment $env, ListForm $args);
}
