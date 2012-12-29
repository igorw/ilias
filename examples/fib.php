<?php

namespace Igorw\Ilias;

require __DIR__.'/../vendor/autoload.php';

if (1 === $argc) {
    echo "Usage: php examples/fib.php NUMBER\n";
    exit(1);
}

$program = new Program(
    new Lexer(),
    new Reader(),
    new FormTreeBuilder(),
    new Walker()
);

$env = Environment::standard();

$code = '(define fib (lambda (n)
    (if (< n 2)
        n
        (+ (fib (- n 1)) (fib (- n 2))))))';
$program->evaluate($env, $code);

$code = sprintf('(fib %s)', (int) $argv[1]);
$value = $program->evaluate($env, $code);
var_dump($value);
