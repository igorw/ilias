<?php

namespace Igorw\Ilias;

class Program
{
    private $lexer;
    private $reader;

    public function __construct(Lexer $lexer, Reader $reader)
    {
        $this->lexer = $lexer;
        $this->reader = $reader;
    }

    public function evaluate($code, Environment $env)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->reader->parse($tokens);

        return $env->evaluate($ast);
    }
}
