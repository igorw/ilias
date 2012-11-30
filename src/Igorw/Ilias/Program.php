<?php

namespace Igorw\Ilias;

class Program
{
    private $lexer;
    private $parser;

    public function __construct(Lexer $lexer, SexprParser $parser)
    {
        $this->lexer = $lexer;
        $this->parser = $parser;
    }

    public function evaluate($code, Environment $env)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->parser->parse($tokens);

        return $env->evaluate($ast);
    }
}
