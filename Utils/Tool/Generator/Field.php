<?php
namespace Utils\Tool\Generator;
use Utils\Tool\Generator\Base;
abstract class Field extends Base{
	public function genFunctionContent($p_pFunction) {
		$arrConfig = $this->getFieldConfig($p_pFunction);
		$strContent = '';
		if(!empty($arrConfig)){
			foreach($arrConfig as $k => $v){
				$strContent .= '		$pFlied = new Field('.$k.', ';
				$strContent .= str_replace("\n", "\n		", var_export($v, true)).');'.PHP_EOL;
				$strContent .= '		if(!$pFlied->valid()){'.PHP_EOL;
				$strContent .= '			return false;'.PHP_EOL;
				$strContent .= '		}'.PHP_EOL;
			}
		}
		$strContent .= '		return true;'.PHP_EOL;
		return $strContent;
	}
	abstract function getFieldConfig($p_pFunction);
}