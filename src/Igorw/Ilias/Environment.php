<?php

namespace Igorw\Ilias;

class Environment extends \ArrayObject
{
    public static function standard()
    {
        return new static([
            'define'    => new SpecialOp\DefineOp(),
            'lambda'    => new SpecialOp\LambdaOp(),
            'if'        => new SpecialOp\IfOp(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
        ]);
    }
}
