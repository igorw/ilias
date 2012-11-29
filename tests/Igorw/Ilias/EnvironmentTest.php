<?php

namespace Igorw\Ilias;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function executeShouldReturnValue()
    {
        $env = new Environment();
        $this->assertSame(2, $env->execute('2'));
    }

    /** @test */
    public function executeSimpleExpression()
    {
        $env = new Environment();
        $this->assertSame(3, $env->execute('(+ 1 2)'));
    }

    /** @test */
    public function executeNestedExpression()
    {
        $env = new Environment();
        $this->assertSame(6, $env->execute('(+ 1 (+ 2 3))'));
    }

    /** @test */
    public function executeDeeplyNestedExpression()
    {
        $env = new Environment();
        $this->assertSame(42, $env->execute('(+ 1 (+ 2 (+ 3 4 5 6 (+ 6 4 3 2) 5 1)))'));
    }
}
