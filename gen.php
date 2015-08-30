<?php
include 'boot.php';
use Utils\Tool\Generator\Manager;
if(PHP_SAPI == 'cli')
{
	$nLen =  count($argv);
	if($nLen < 2 || $nLen>9 ){
		Manager::useage();
	}
	$arrMap = array(
			'-i' => '\Utils\Tool\Generator\Input',
			'-o' => '\Utils\Tool\Generator\Output',
			'-t' => '\Utils\Tool\Generator\Test',
			'-c' => '\Utils\Tool\Generator\Client',
			'-d' => '\Utils\Tool\Generator\DefaultResult'
	);
	Manager::configurate($arrMap);
	Manager::gen($argv);
}
else{
	Manager::useage();
}
