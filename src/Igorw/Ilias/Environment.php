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
            'defmacro'  => new SpecialForm\DefMacroForm(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
            'list'      => new Func\ListFunc(),
            'begin'     => new Func\BeginFunc(),
        ]);
    }
}
