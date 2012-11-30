<?php

namespace Igorw\Ilias\Fexpr;

use Igorw\Ilias\Environment;

interface Fexpr
{
    public function invoke(Environment $env, array $args);
}
