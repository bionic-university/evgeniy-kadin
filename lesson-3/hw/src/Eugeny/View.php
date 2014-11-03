<?php
namespace Eugeny;
/**
 * Class View
 * @package Eugeny
 */
class View{
    /**
     * @param $messages
     */
    public function showChefMessages($messages){
		foreach($messages as $message){
			echo $message.PHP_EOL;
		}
	}
}
