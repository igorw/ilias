# Ilias

Crappy LISP implementation in PHP.

## Usage

    use Igorw\Ilias\Tokenizer;
    use Igorw\Ilias\SexprParser;
    use Igorw\Ilias\Environment;
    use Igorw\Ilias\Program;

    $program = new Program(
        new Tokenizer(),
        new SexprParser()
    );

    $env = new Environment();
    $value = $program->evaluate('(+ 1 2)', $env);
    var_dump($value);
