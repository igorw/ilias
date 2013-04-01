<?php

namespace integration;

use Igorw\Ilias\Program;
use Igorw\Ilias\Lexer;
use Igorw\Ilias\Reader;
use Igorw\Ilias\FormTreeBuilder;
use Igorw\Ilias\Walker;
use Igorw\Ilias\Environment;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
    private $program;
    private $env;

    public function setUp()
    {
        $this->program = new Program(
            new Lexer(),
            new Reader(),
            new FormTreeBuilder(),
            new Walker()
        );

        $this->env = Environment::standard();
    }

    /**
     * @test
     * @dataProvider provideEvaluate
     */
    public function evaluate($expected, $code, array $vars = [])
    {
        foreach ($vars as $name => $value) {
            $this->env[$name] = $value;
        }

        $value = $this->program->evaluate($this->env, $code);
        $this->assertSame($expected, $value);
    }

    public function provideEvaluate()
    {
        return [
            'empty'                 => [null, ''],
            'value'                 => [3, '(+ 1 2)'],
            'variable'              => [42, 'foo', ['foo' => 42]],
            'lambda'                => [
                42,
                '(define identity (lambda (x) x)) (identity 42)',
            ],
            'lambda with real body' => [
                51,
                '(define add-one (lambda (x) (+ x 1))) (add-one 50)',
            ],
            'addition'              => [100, '(+ 1 2 3 94)'],
            'subtraction'           => [194, '(- 200 1 2 3)'],
            'if'                    => [2, '(if 1 2 3)'],
            'if with real body'     => [2, '(if 1 (+ 1 1) (+ 1 1 1))'],
            'if with false cond'    => [3, '(if 0 (+ 1 1) (+ 1 1 1))'],
            'if without else'       => [null, '(if 0 2)'],
            'if with cond body'     => [3, '(if (- 1 1) 2 3)'],
            'single level macro'    => [
                3,
                "(defmacro plus (a b) (list '+ a b))
                 (plus 1 2)",
            ],
            'two level macro'       => [
                3,
                "(defmacro plus (a b) (list '+ a b))
                 (defmacro pl (a b) (list 'plus a b))
                 (pl 1 2)",
            ],
            'when macro'            => [
                3,
                "(defmacro when (condition a b c)
                    (list 'if condition (list 'begin a b c)))
                 (define foo
                    (lambda (x)
                        (when (> x 10) 1 2 3)))
                 (foo 11)",
            ],
            'quoted symbol'    => [
                'foo',
                "'foo",
            ],
            'id of quoted symbol'    => [
                'foo',
                "(define identity (lambda (x) x)) (identity 'foo)",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider provideEvaluateQuote
     */
    public function evaluateQuote($expected, $code)
    {
        $value = $this->program->evaluate($this->env, $code);
        $this->assertEquals($expected, $value);
    }

    public function provideEvaluateQuote()
    {
        return [
            'quoted string'         => ['foo', "'foo"],
            'quoted list'           => [['foo'], "'(foo)"],
            'nested quoted list'    => [[['foo']], "'((foo))"],
        ];
    }

    /** @test */
    public function evaluateDefine()
    {
        $this->program->evaluate($this->env, '(define foo 42)');
        $this->assertSame(42, $this->env['foo']);
    }

    /** @test */
    public function evaluateGreaterThan()
    {
        $this->assertSame(true, $this->program->evaluate($this->env, '(> 5 4)'));
        $this->assertSame(false, $this->program->evaluate($this->env, '(> 5 5)'));
        $this->assertSame(false, $this->program->evaluate($this->env, '(> 5 6)'));
    }

    /** @test */
    public function evaluateLessThan()
    {
        $this->assertSame(true, $this->program->evaluate($this->env, '(< 4 5)'));
        $this->assertSame(false, $this->program->evaluate($this->env, '(< 5 5)'));
        $this->assertSame(false, $this->program->evaluate($this->env, '(< 6 5)'));
    }

    /**
     * @test
     * @dataProvider provideFibonacci
     */
    public function evaluateFibonacci($expected, $n)
    {
        $code = '(define fib (lambda (n)
            (if (< n 2)
                n
                (+ (fib (- n 1)) (fib (- n 2))))))';
        $this->program->evaluate($this->env, $code);
        $this->assertSame($expected, $this->program->evaluate($this->env, sprintf('(fib %s)', $n)));
    }

    public function provideFibonacci()
    {
        return [
            [1,  1],
            [1,  2],
            [2,  3],
            [3,  4],
            [5,  5],
            [8,  6],
            [13, 7],
            [21, 8],
            [34, 9],
            [55, 10],
        ];
    }

    /**
     * @test
     * @dataProvider provideSpecialOp
     */
    public function specialOp($expected, $code)
    {
        $value = $this->program->evaluate($this->env, $code);
        $this->assertEquals($expected, $value);
    }

    public function provideSpecialOp()
    {
        return [
            ['foo', '(quote foo)'],
            [['foo'], '(quote (foo))'],
            [['foo', 'bar', 'baz'], '(quote (foo bar baz))'],
            [['quote', ['quote', 'foo']], '(quote (quote (quote foo)))'],
            [[], '(quote ())'],

            [null, '(cond)'],
            ['foo', '(cond (#else (quote foo)))'],
            ['foo', '(cond (true (quote foo)) (#else (quote bar)))'],
            ['bar', '(cond (false (quote foo)) (#else (quote bar)))'],
        ];
    }

    /**
     * @test
     * @dataProvider provideFunc
     */
    public function func($expected, $code)
    {
        $value = $this->program->evaluate($this->env, $code);
        $this->assertEquals($expected, $value);
    }

    public function provideFunc()
    {
        return [
            [true, '(eq? 1 1)'],
            [true, '(eq? 3 (+ 1 2))'],
            [false, '(eq? 1 2)'],
            [true, '(eq? (quote a) (quote a))'],
            [false, '(eq? (quote a) (quote b))'],
        ];
    }
}
