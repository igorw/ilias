# Ilias

Naive LISP implementation in PHP. For something more complete, check out
[Lisphp](https://github.com/lisphp/lisphp).

Check out the [s-expression blog posts](https://igor.io/2012/12/06/sexpr.html)
explaining the implementation of Ilias.

## Usage

```php
use Igorw\Ilias\Program;
use Igorw\Ilias\Lexer;
use Igorw\Ilias\Reader;
use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Walker;
use Igorw\Ilias\Environment;

$program = new Program(
    new Lexer(),
    new Reader(),
    new FormTreeBuilder(),
    new Walker()
);

$env = Environment::standard();
$value = $program->evaluate($env, '(+ 1 2)');
var_dump($value);
```

will output:

```
int(3)
```
