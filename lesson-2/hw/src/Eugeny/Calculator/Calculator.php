<?php
namespace Eugeny\Calculator;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Eugeny\Exception as Exception;
use Eugeny\Token as Token;

/**
 * Class Calculator
 * @package Eugeny\Calculator
 * This class implements simple mathematical parser.
 * It implements shunting-yard algorithm by Edsger Dijkstra for converting infix notation to postfix notation
 * @link http://en.wikipedia.org/wiki/Shunting-yard_algorithm
 * Also implements algorithm for parsing postfix expressions
 * @link http://www.smccd.net/accounts/hasson/C++2Notes/ArithmeticParsing.html
 * @author Eugeny Kadin <montekidlo@gmail.com>
 * @version 1.0.0.0
 */
class Calculator
{
    /**
     * path to logs
     */
    const LOG_PATH = "logs/debug.log";

    /**
     * @var string expression
     */
    private $expression = '';
    /**
     * @var int|float calculated result
     */
    private $result = 0;
    /**
     * @var array with operations
     */
    private $operations = array('+', '-', '*', '/');
    /**
     * @var array with tokens
     */
    private $tokenStream = array();
    /**
     * @var array rearranged array with postfix notation
     */
    private $postfixArray = array();
    /**
     * @var \Monolog\Logger|null
     */
    private $log = null;

    /**
     * @param $expression
     */
    public function __construct($expression)
    {
        $this->expression = $this->cleanExpression($expression);
        $this->log = new Logger('name');
        $this->log->pushHandler(new StreamHandler(self::LOG_PATH, Logger::DEBUG));
        $this->log->addDebug("start calculation, entered expression - " . $this->expression);
    }

    /**
     * Clean for incorrect symbols
     *
     * @param $expression
     * @return mixed
     * @throws \Eugeny\Exception\ParseExpressionException
     * @throws \Eugeny\Exception\EmptyExpressionException
     */
    private function cleanExpression($expression)
    {
        $expressionString = preg_replace("@[^0-9+-/*.]+@", "", $expression);
        if (empty($expressionString)) {
            throw new Exception\EmptyExpressionException("please enter expression!");
        }
        //simple validation for incorrect expression
        $endSymbol = substr($expressionString, -1);
        if (in_array($endSymbol, $this->operations) || (!is_numeric(
                    $expressionString[0]
                ) && $expressionString[0] != '-')
        ) {
            throw new Exception\ParseExpressionException("Please enter valid expression!");
        }

        return $expressionString;
    }

    /**
     * calculate expression
     */
    public function calculate()
    {
        $this->tokenizeExpression();
        $this->convertInfixToPostfix();
        $this->evaluteExpression();
    }

    /**
     * split expression to array with token objects
     */
    private function tokenizeExpression()
    {
        $tokensArray = preg_split(
            '@([\d\.]+)|(\+|\-|\*|/|)@',
            $this->expression,
            null,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        );
        foreach ($tokensArray as $tokenSymbol) {
            $this->tokenStream[] = Token\TokenFactory::createToken($tokenSymbol);
        }
        if ($this->tokenStream[0] instanceOf Token\AbstractOperationToken) {
            //handle situation, where we have expression "-Number", so need add neutral element.
            //For minus operation it is 0, for multiple - 1, for plus - 0, for devision - exception.
            //For example we have input expression -10+20. In this implementation it should be 0-10+20

            array_unshift(
                $this->tokenStream,
                Token\TokenFactory::createToken($this->tokenStream[0]->getNeutralElement())
            );
        }

    }

    /**
     * converting from infix(human readable notation) to postfix, use shunting-yard algorithm
     */
    private function convertInfixToPostfix()
    {
        $operatorStack = new \SplStack();
        foreach ($this->tokenStream as $token) {
            if ($token instanceOf Token\NumericToken) {
                $this->postfixArray[] = $token;
            }
            if ($token instanceOf Token\AbstractOperationToken) {
                while (!$operatorStack->isEmpty() && $token->getPriority() <= $operatorStack->top()->getPriority()) {
                    $this->postfixArray[] = $operatorStack->pop();
                }
                $operatorStack->push($token);
            }
        }

        while (!$operatorStack->isEmpty()) {
            $this->postfixArray[] = $operatorStack->pop();
        }
        $this->log->addDebug('postfix array - ' . var_export($this->postfixArray, true));
    }

    /**
     * parse postfix notation and evolute expression
     * @throws \Eugeny\Exception\ParseExpressionException
     */
    private function evaluteExpression()
    {
        $stack = new \SplStack();
        foreach ($this->postfixArray as $token) {
            $this->log->addDebug('next token - ' . $token);

            if ($token instanceOf Token\NumericToken) {
                $stack->push($token);
            }
            if ($token instanceOf Token\AbstractOperationToken) {
                if($stack->count() < 2){
                    $this->log->addCritical("Stack has less then 2 elements, original expression - {$this->expression}");
                    throw new Exception\ParseExpressionException("Cann't parse expression");
                }
                $operator2 = $stack->pop();
                $operator1 = $stack->pop();
                $this->log->addDebug($token . $operator1->getValue() . ", " . $operator2->getValue());
                $result = $token->execute($operator1, $operator2);
                $this->log->addDebug('execute - ' . $result);
                $stack->push(Token\TokenFactory::createToken($result));
            }
        }
        if($stack->isEmpty()){
            $this->log->addCritical("Stack is empty, original expression - {$this->expression}");
            throw new Exception\ParseExpressionException("Cann't parse expression");
        }
        $this->result = $stack->pop()->getValue();
    }

    /**
     * get obtained result
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    public static function createExpressionStringByArray(array $params)
    {
        return implode($params);
    }
}
