<?php
namespace Utils\Tool\Generator;
use Utils\Tool\Generator\Base;
class DefaultResult extends Base{
	public $bDoc = true;
	protected $strBase = 'Default';
	public function genFunctionContent($p_pFunction) {
		$mxDefault = $this->parseDefault($p_pFunction);
		$strContent = '';
		$strContent .= '		return '.$mxDefault.';'.PHP_EOL;
		return $strContent;
	}
}