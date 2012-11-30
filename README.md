# Ilias

Naive LISP implementation in PHP. For something more complete, check out
[Lisphp](https://github.com/lisphp/lisphp).

## Usage

    use Igorw\Ilias\Lexer;
    use Igorw\Ilias\Reader;
    use Igorw\Ilias\Environment;
    use Igorw\Ilias\Program;

    $program = new Program(
        new Lexer(),
        new Reader()
    );

    $env = Environment::standard();
    $value = $program->evaluate('(+ 1 2)', $env);
    var_dump($value);
