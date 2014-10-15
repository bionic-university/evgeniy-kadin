<?php
namespace Eugeny\Token;

/**
 * Class PlusToken
 * @package Eugeny\Token
 */
class PlusToken extends AbstractOperationToken
{
    /**
     * @return int
     */
    public function getPriority()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getNeutralElement()
    {
        return 1;
    }

    /**
     * @param $value1
     * @param $value2
     * @return mixed
     */
    public function execute($value1, $value2)
    {
        return $value1->getValue() + $value2->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "+";
    }

}
