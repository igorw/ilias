<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;
use Igorw\Ilias\Form\ListForm;

interface Fexpr
{
    public function apply(Environment $env, ListForm $args);
}
