<?php
namespace Eugeny\Token;

use \Eugeny\Exception as Exception;

/**
 * Class DivisionToken
 * @package Eugeny\Token
 */
class DivisionToken extends AbstractOperationToken
{
    /**
     * @return int
     */
    public function getPriority()
    {
        return 2;
    }

    /**
     * @throws \Exception
     */
    public function getNeutralElement()
    {
        throw new \Exception();
    }

    /**
     * @param $operand1
     * @param $operand2
     * @return float
     * @throws \Eugeny\Exception\MathematicalException
     */
    public function execute($operand1, $operand2)
    {
        $value2 = $operand2->getValue();
        if (empty($value2)) {
            throw new Exception\MathematicalException('Division by zero!');
        }
        return $operand1->getValue() / $operand2->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "/";
    }
}
