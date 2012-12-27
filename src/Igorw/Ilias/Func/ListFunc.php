<?php

namespace Igorw\Ilias\Func;

use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Form\ListForm;

class ListFunc
{
    public function __invoke()
    {
        return new ListForm(func_get_args());
    }
}
