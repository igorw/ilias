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
}
