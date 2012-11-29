<?php

namespace Igorw\Ilias;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function evaluateShouldReturnValue()
    {
        $env = new Environment();
        $this->assertSame(2, $env->evaluate('2'));
    }

    /** @test */
    public function evaluateSimpleExpression()
    {
        $env = new Environment();
        $this->assertSame(3, $env->evaluate('(+ 1 2)'));
    }

    /** @test */
    public function evaluateNestedExpression()
    {
        $env = new Environment();
        $this->assertSame(6, $env->evaluate('(+ 1 (+ 2 3))'));
    }

    /** @test */
    public function evaluateDeeplyNestedExpression()
    {
        $env = new Environment();
        $this->assertSame(42, $env->evaluate('(+ 1 (+ 2 (+ 3 4 5 6 (+ 6 4 3 2) 5 1)))'));
    }
}
