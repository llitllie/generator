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