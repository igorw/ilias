<?php

namespace Igorw\Ilias;

class Program
{
    private $tokenizer;
    private $parser;

    public function __construct(Tokenizer $tokenizer, SexprParser $parser)
    {
        $this->tokenizer = $tokenizer;
        $this->parser = $parser;
    }

    public function evaluate($code, Environment $env)
    {
        $tokens = $this->tokenizer->tokenize($code);
        $ast = $this->parser->parse($tokens);

        return $env->evaluate($ast);
    }
}
