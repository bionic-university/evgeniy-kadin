<?php
namespace Eugeny\Products;
use \Eugeny\Interfaces\ISlicable;

/**
 * Class Bread
 * @package Eugeny\Products
 */
class Bread implements ISlicable{
    /**
     * @return string
     */
    public function __toString(){
		return "bread";
	}
}
