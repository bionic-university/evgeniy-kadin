<?php
include "vendor/autoload.php";
if(isset($argv[1])){
	try{			
	$chef = new Eugeny\Chef($argv[1]);
	$chef->cook();
	$view = new Eugeny\View();
	$view->showChefMessages($chef->getActionMessages());
	}catch(\Exception $e){
		echo $e->getMessage();
	}
}else{
	echo Eugeny\Chef::getDefaultMessage();			
}
