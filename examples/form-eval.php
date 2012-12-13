<?php

namespace Igorw\Ilias;

require __DIR__.'/../vendor/autoload.php';

$ast = [
    ['+', 1, 2],
    ['+', 1, ['+', 2, 3]],
    [['get-plus-func'], 1, 2],
    ['get-random-number'],
];

$env = Environment::standard();
$env['get-plus-func'] = function () use ($env) {
    return $env['+'];
};
$env['get-random-number'] = function () {
    return 4;
};

$builder = new FormTreeBuilder();
$forms = $builder->parseAst($ast);

foreach ($forms as $form) {
    print_r($form->getAst());
    var_dump($form->evaluate($env));
}
