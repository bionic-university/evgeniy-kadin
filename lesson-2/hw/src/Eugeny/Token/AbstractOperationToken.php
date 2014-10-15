<?php
namespace Eugeny\Token;

/**
 * Class AbstractOperationToken
 * @package Eugeny\Token
 */
abstract class AbstractOperationToken
{
    /**
     * @return int
     */
    abstract public function getPriority();

    /**
     * @return int
     */
    abstract public function getNeutralElement();

    /**
     * operation with two elements, it can be subtraction or multiplying
     * @param $operand1
     * @param $operand2
     * @return int|float
     */
    abstract public function execute($operand1, $operand2);
}
