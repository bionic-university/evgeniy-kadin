<?php
namespace Eugeny;
use Interfaces\ISlicable;
use Interfaces\IGrillable;

/**
 * Class Chef
 * @package Eugeny
 */
class Chef{
    /**
     * @var Products\Bread|Products\Meat|Products\Potatoe
     */
    private $product        = null;
    /**
     * @var array
     */
    private $actionMessages = array();

    /**
     * @param $type
     */
    public function __construct($type){
		$this->product = $this->productFactory($type);
	}

    /**
     * @return string
     */
    public static function getDefaultMessage(){
		return "please enter type of product.".PHP_EOL.
			"	Possible cases: ".PHP_EOL.
			"- bread".PHP_EOL."- meat".PHP_EOL.
			"- potato".PHP_EOL;			
	}

    /**
     *
     */
    public function cook(){
		if($this->product instanceof Interfaces\ISlicable){
			$this->actionMessages[] = $this->slice();
		}	
		if($this->product instanceof Interfaces\IGrillable){
			$this->actionMessages[] = $this->grill();
		}
	}

    /**
     * @return string
     */
    private function slice(){
		return "slice {$this->product}";	
	}

    /**
     * @return string
     */
    private function grill(){
		return "grill {$this->product}";
	}

    /**
     * @param $type
     * @return Products\Bread|Products\Meat|Products\Potatoe
     * @throws \Exception
     */
    private function productFactory($type){
		switch($type){
			case 'bread':
				return new Products\Bread();
				break;
			case 'meat':
				return new Products\Meat();
				break;
			case 'potatoe':
				return new Products\Potatoe();
				break;
			default:
				throw new \Exception(self::getDefaultMessage());			
		}
	}

    /**
     * @return array
     */
    public function getActionMessages(){
		return $this->actionMessages;
	}

}

