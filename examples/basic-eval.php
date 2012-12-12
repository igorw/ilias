<?php

namespace Igorw\Ilias;

function evaluateAst(array $ast, array $env)
{
    $value = null;
    foreach ($ast as $sexpr) {
        $value = evaluate($sexpr, $env);
    }
    return $value;
}

function evaluate($sexpr, array $env)
{
    $fn = car($sexpr);
    $args = cdr($sexpr);

    return call_user_func_array($env[$fn], $args);
}

function car(array $list)
{
    return $list[0];
}

function cdr(array $list)
{
    return array_slice($list, 1);
}

function plus(/* $numbers... */)
{
    return array_sum(func_get_args());
}

function environment()
{
    return [
        '+' => 'Igorw\Ilias\plus',
    ];
}

require __DIR__.'/../vendor/autoload.php';

$ast = [['+', 1, 2]];
$env = environment();
var_dump(evaluateAst($ast, $env));
