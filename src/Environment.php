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
            'defmacro'  => new SpecialOp\DefMacroOp(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
            'list'      => new Func\ListFunc(),
            'begin'     => new Func\BeginFunc(),
        ]);
    }
}
