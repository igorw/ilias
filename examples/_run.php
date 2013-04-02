<?php

require __DIR__.'/../vendor/autoload.php';

use Igorw\Ilias\Program;
use Igorw\Ilias\Lexer;
use Igorw\Ilias\Reader;
use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Walker;
use Igorw\Ilias\Environment;

function run($code)
{
    $program = new Program(
        new Lexer(),
        new Reader(),
        new FormTreeBuilder(),
        new Walker()
    );

    $env = Environment::standard();
    $value = $program->evaluate($env, $code);
    var_dump($value);
}
