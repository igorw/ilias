<?php

namespace Igorw\Ilias;

class Environment extends \ArrayObject
{
    public static function standard()
    {
        return new static([
            'define'    => new SpecialForm\DefineForm(),
            'lambda'    => new SpecialForm\LambdaForm(),
            'if'        => new SpecialForm\IfForm(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
        ]);
    }
}
