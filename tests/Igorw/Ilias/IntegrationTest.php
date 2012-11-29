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

        $this->env = new Environment();
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
        $this->program->evaluate('(define identity (lambda (x) (x)))', $this->env);
        $this->assertSame(42, $this->program->evaluate('(identity 42)', $this->env));
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
}
