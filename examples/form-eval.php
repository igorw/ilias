<?php

namespace Igorw\Ilias;

require __DIR__.'/../vendor/autoload.php';

$ast = [
    ['+', 1, 2],
    ['+', 1, ['+', 1, 1]],
    [['get-plus-func'], 1, 2],
];

$env = Environment::standard();
$env['get-plus-func'] = function () use ($env) {
    return $env['+'];
};

$builder = new FormTreeBuilder();
$forms = $builder->parseAst($ast);

foreach ($forms as $form) {
    print_r($form->getAst());
    var_dump($form->evaluate($env));
}
