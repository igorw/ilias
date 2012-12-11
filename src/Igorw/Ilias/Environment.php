<?php

namespace Igorw\Ilias;

class Environment extends \ArrayObject
{
    public function offsetGet($key)
    {
        return isset($this[$key]) ? parent::offsetGet($key) : null;
    }

    public static function standard()
    {
        return new static([
            'define'    => new Fexpr\DefineFexpr(),
            'lambda'    => new Fexpr\LambdaFexpr(),
            'if'        => new Fexpr\IfFexpr(),

            '+'         => new Func\PlusFunc(),
            '-'         => new Func\MinusFunc(),
            '>'         => new Func\GreaterThanFunc(),
            '<'         => new Func\LessThanFunc(),
        ]);
    }
}
