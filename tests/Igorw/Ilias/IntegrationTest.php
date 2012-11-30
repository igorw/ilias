<?php

namespace Igorw\Ilias;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    private $program;

    public function setUp()
    {
        $this->program = new Program(
            new Tokenizer(),
            new SexprParser()
        );

        $this->env = Environment::standard();
    }

    /** @test */
    public function evaluateValue()
    {
        $this->assertSame(3, $this->program->evaluate('(+ 1 2)', $this->env));
    }

    /** @test */
    public function evaluateDefine()
    {
        $this->program->evaluate('(define foo 42)', $this->env);
        $this->assertSame(42, $this->env['foo']);
    }

    /** @test */
    public function evaluateVariable()
    {
        $this->env['foo'] = 42;
        $this->assertSame(42, $this->program->evaluate('foo', $this->env));
    }

    /** @test */
    public function evaluateQuotedString()
    {
        $this->assertSame('foo', $this->program->evaluate("'foo", $this->env));
    }

    /** @test */
    public function evaluateQuotedList()
    {
        $this->assertSame(['foo'], $this->program->evaluate("'(foo)", $this->env));
    }

    /** @test */
    public function evaluateNestedQuotedList()
    {
        $this->assertSame([['foo']], $this->program->evaluate("'((foo))", $this->env));
    }

    /** @test */
    public function evaluateLambda()
    {
        $this->program->evaluate('(define identity (lambda (x) x))', $this->env);
        $this->assertSame(42, $this->program->evaluate('(identity 42)', $this->env));
    }

    /** @test */
    public function evaluateLambdaWithRealBody()
    {
        $this->program->evaluate('(define add-one (lambda (x) (+ x 1)))', $this->env);
        $this->assertSame(51, $this->program->evaluate('(add-one 50)', $this->env));
    }

    /** @test */
    public function evaluateAdditionArithmetic()
    {
        $this->assertSame(100, $this->program->evaluate('(+ 1 2 3 94)', $this->env));
    }

    /** @test */
    public function evaluateSubtractionArithmetic()
    {
        $this->assertSame(194, $this->program->evaluate('(- 200 1 2 3)', $this->env));
    }

    /** @test */
    public function evaluateIf()
    {
        $this->assertSame(2, $this->program->evaluate('(if 1 2 3)', $this->env));
    }

    /** @test */
    public function evaluateIfWithRealBody()
    {
        $this->assertSame(2, $this->program->evaluate('(if 1 (+ 1 1) (+ 1 1 1))', $this->env));
    }

    /** @test */
    public function evaluateIfWithFalseCondition()
    {
        $this->assertSame(3, $this->program->evaluate('(if 0 (+ 1 1) (+ 1 1 1))', $this->env));
    }

    /** @test */
    public function evaluateIfWithoutElse()
    {
        $this->assertSame(null, $this->program->evaluate('(if 0 2)', $this->env));
    }

    /** @test */
    public function evaluateIfWithConditionBody()
    {
        $this->assertSame(3, $this->program->evaluate('(if (- 1 1) 2 3)', $this->env));
    }

    /** @test */
    public function evaluateGreaterThan()
    {
        $this->assertSame(true, $this->program->evaluate('(> 5 4)', $this->env));
        $this->assertSame(false, $this->program->evaluate('(> 5 5)', $this->env));
        $this->assertSame(false, $this->program->evaluate('(> 5 6)', $this->env));
    }

    /** @test */
    public function evaluateLessThan()
    {
        $this->assertSame(true, $this->program->evaluate('(< 4 5)', $this->env));
        $this->assertSame(false, $this->program->evaluate('(< 5 5)', $this->env));
        $this->assertSame(false, $this->program->evaluate('(< 6 5)', $this->env));
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
        $this->program->evaluate($code, $this->env);
        $this->assertSame($expected, $this->program->evaluate(sprintf('(fib %s)', $n), $this->env));
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
