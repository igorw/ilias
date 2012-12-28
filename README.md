# Ilias

Naive LISP implementation in PHP. For something more complete, check out
[Lisphp](https://github.com/lisphp/lisphp).

## Usage

    use Igorw\Ilias\Lexer;
    use Igorw\Ilias\Reader;
    use Igorw\Ilias\FormGraphBuilder;
    use Igorw\Ilias\Walker;
    use Igorw\Ilias\Environment;
    use Igorw\Ilias\Program;

    $program = new Program(
        new Lexer(),
        new Reader(),
        new FormTreeBuilder(),
        new Walker()
    );

    $env = Environment::standard();
    $value = $program->evaluate('(+ 1 2)', $env);
    var_dump($value);
