<?php
namespace Eugeny\Products;
use \Eugeny\Interfaces\IGrillable;

/**
 * Class Meat
 * @package Eugeny\Products
 */
class Meat implements IGrillable{
    /**
     * @return string
     */
    public function __toString(){
		return "meat";
	}
}
