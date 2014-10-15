<?php
namespace Eugeny\Tests;

use \Eugeny\Calculator as Calc;
use \Eugeny\Exception as Exception;

/**
 * Class CalculatorTest
 * @package Eugeny\Tests
 */
class CalculatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider getCorrectExpressionsProvider
     */
    public function testCalculatingCorrectExpression($expression)
    {
        eval('$evalutedResult = ' . $expression . ';');
        $result = $this->callCalculator($expression);
        $this->assertEquals($evalutedResult, $result);
    }

    /**
     * @return array
     */
    public function getCorrectExpressionsProvider()
    {
        return array(
            array('2+2'),
            array('7+9'),
            array('18-6'),
            array('5*8'),
            array('50/5'),
            array('10+5*10'),
            array('5-10*20+7'),
            array('-1+2 - 3*9+9/2'),
            array('5.2-1/5+2')
        );
    }

    /**
     * @expectedException \Eugeny\Exception\EmptyExpressionException
     */
    public function testEmptyExpression(){
        $this->callCalculator("");
    }


    public function callCalculator($expression){
        $calculator = new Calc\Calculator($expression);
        $calculator->calculate();
        return $calculator->getResult();
    }

    /**
     * @dataProvider getIncorrectExpressionsProvider
     * @expectedException \Eugeny\Exception\ParseExpressionException
     */
    public function testCalculatingIncorrectExpression($expression)
    {
        $this->callCalculator($expression);
    }


    /**
     * @return array
     */
    public function getIncorrectExpressionsProvider()
    {
        return array(
            array('1+'),
            array('1++1')
        );
    }

    /**
     *
     * @expectedException \Eugeny\Exception\MathematicalException
     */
    public function testDivisionByZero()
    {
        $this->callCalculator("1/0");
    }


}
