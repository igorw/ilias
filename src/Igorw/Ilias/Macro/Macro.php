<?php

namespace Igorw\Ilias\Macro;

use Igorw\Ilias\Environment;

interface Macro
{
    public function invoke(Environment $env, array $args);
}
