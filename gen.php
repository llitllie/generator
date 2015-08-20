<?php
define('ROOT_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
spl_autoload_register(function($p_strClassName){
	$arrClassName = explode('\\', trim($p_strClassName, '\\'));
	$strPath = ROOT_PATH.implode(DIRECTORY_SEPARATOR, $arrClassName).'.php';
	if(is_file($strPath)){
		include $strPath;
	}
	else{
		throw new \Exception('File Not Exist:'.$strPath.PHP_EOL);
	}
});
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
