<?php
namespace Eugeny\Products;
use \Eugeny\Interfaces\ISlicable;
use \Eugeny\Interfaces\IGrillable;

/**
 * Class Potatoe
 * @package Eugeny\Products
 */
class Potatoe implements ISlicable, IGrillable{
    /**
     * @return string
     */
    public function __toString(){
		return "potatoe";
	}
}
