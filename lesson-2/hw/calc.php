<?php
include "vendor/autoload.php";

//need clean argv array
array_shift($argv);
try{
    $expressionString = \Eugeny\Calculator\Calculator::createExpressionStringByArray($argv);
	$calculator       = new \Eugeny\Calculator\Calculator($expressionString);
	$calculator->calculate();
	echo $calculator->getResult().PHP_EOL;
}catch(Exception $e){
	echo $e->getMessage().PHP_EOL;
}
