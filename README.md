# Ilias

Naive LISP implementation in PHP. For something more complete, check out
[LisPHP](https://github.com/lisphp/lisphp).

## Usage

    use Igorw\Ilias\Lexer;
    use Igorw\Ilias\SexprParser;
    use Igorw\Ilias\Environment;
    use Igorw\Ilias\Program;

    $program = new Program(
        new Lexer(),
        new SexprParser()
    );

    $env = Environment::standard();
    $value = $program->evaluate('(+ 1 2)', $env);
    var_dump($value);
