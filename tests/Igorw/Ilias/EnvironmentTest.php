<?php

namespace Igorw\Ilias;

class EnvironmentTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function constructorShouldSetVar()
    {
        $env = new Environment(['foo' => 'bar']);
        $this->assertSame('bar', $env['foo']);
    }

    /** @test */
    public function offsetSetShouldSetVar()
    {
        $env = new Environment();
        $env['foo'] = 'bar';
        $this->assertSame('bar', $env['foo']);
    }

    /** @test */
    public function offsetExistsShouldCheckVarExistence()
    {
        $env = new Environment();
        $this->assertFalse(isset($env['foo']));
        $env['foo'] = 'bar';
        $this->assertTrue(isset($env['foo']));
    }

    /** @test */
    public function offsetUnsetShouldUnsetVar()
    {
        $env = new Environment();
        $env['foo'] = 'bar';
        unset($env['foo']);
        $this->assertSame(null, $env['foo']);
    }

    /**
     * @test
     * @dataProvider provideEvaluate
     */
    public function evaluate($expected, $input)
    {
        $env = Environment::standard();
        $this->assertSame($expected, $env->evaluate([$input]));
    }

    public function provideEvaluate()
    {
        return [
            'value'                     => [2, 2],
            'simple expression'         => [3, ['+', 1, 2]],
            'nested expression'         => [6, ['+', 1, ['+', 2, 3]]],
            'deeply nested expression'  => [
                42,
                ['+', 1, ['+', 2, ['+', 3, 4, 5, 6, ['+', 6, 4, 3, 2], 5, 1]]],
            ],
        ];
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage Tried to invoke non-existent function foo
     */
    public function nonExistentFunctionShouldThrowException()
    {
        $env = new Environment();
        $this->assertSame(42, $env->evaluate([['foo']]));
    }
}
