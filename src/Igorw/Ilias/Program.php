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

    public function evaluate(Environment $env, $code)
    {
        $tokens = $this->lexer->tokenize($code);
        $ast = $this->reader->parse($tokens);

        $builder = new FormGraphBuilder();
        $forms = $builder->parse($ast);

        $value = null;
        foreach ($forms as $form) {
            $value = $form->evaluate($env);
        }
        return $value;
    }
}
