<?php
namespace Eugeny\Token;

/**
 * Class TokenFactory
 * @package Eugeny\Token
 */
class TokenFactory
{
    /**
     * create token object by input symbol
     * @param $symbol
     * @return DivisionToken|MinusToken|MultiplyToken|NumericToken|PlusToken
     */
    public static function createToken($symbol)
    {
        if (is_numeric($symbol)) {
            return new NumericToken($symbol);
        }
        switch ($symbol) {
            case '-':
                return new MinusToken();
                break;
            case '+':
                return new PlusToken();
                break;
            case '*':
                return new MultiplyToken();
                break;
            case '/':
                return new DivisionToken();
                break;

        }
    }
}
