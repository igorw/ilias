<?php

namespace Igorw\Ilias;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $program;
    private $env;

    public function setUp()
    {
        $this->program = new Program(
            new Lexer(),
            new Reader(),
            new FormTreeBuilder()
        );

        $this->env = Environment::standard();
    }

    /**
     * @test
     * @dataProvider provideEvaluate
     */
    public function evaluate($expected, $code, array $vars = array())
    {
        foreach ($vars as $name => $value) {
            $this->env[$name] = $value;
        }

        $this->assertSame($expected, $this->program->evaluate($this->env, $code));
    }

    public function provideEvaluate()
    {
        return [
            'empty'                 => [null, ''],
            'value'                 => [3, '(+ 1 2)'],
            'variable'              => [42, 'foo', ['foo' => 42]],
            'quoted string'         => ['foo', "'foo"],
            'quoted list'           => [['foo'], "'(foo)"],
            'nested quoted list'    => [[['foo']], "'((foo))"],
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
}
