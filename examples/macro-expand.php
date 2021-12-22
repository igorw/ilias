<?php

// example call:
// php examples/macro-expand.php
//     "(defmacro when (condition a b c) (list 'if condition (list 'begin a b c)))"
//     "(when (> x 10) 1 2 3)"

namespace Igorw\Ilias;

require __DIR__.'/../vendor/autoload.php';

if ($argc < 3) {
    echo "Usage: php examples/macro-expand.php MACROS CODE\n";
    exit(1);
}

list($_, $macros, $code) = $argv;

$program = new Program(
    new Lexer(),
    new Reader(),
    new FormTreeBuilder(),
    new Walker()
);

$env = Environment::standard();

$program->evaluate($env, $macros);
echo ($program->evaluate($env, $code))."\n";

$expandedForms = expand($env, $code);
foreach ($expandedForms as $expanded) {
    echo encode($expanded->getAst())."\n";
}

function buildForms($code)
{
    $lexer = new Lexer();
    $reader = new Reader();
    $builder = new FormTreeBuilder();

    $tokens = $lexer->tokenize($code);
    $ast = $reader->parse($tokens);
    return $builder->parseAst($ast);
}

function expand(Environment $env, $code)
{
    $walker = new Walker();
    $forms = buildForms($code);

    return array_map(
        function ($form) use ($walker, $env) {
            return $walker->expand($env, $form);
        },
        $forms
    );
}

function encode(array $form)
{
    $encoder = new Encoder();
    return $encoder->encode([$form]);
}
