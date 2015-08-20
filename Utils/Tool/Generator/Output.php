<?php
namespace Utils\Tool\Generator;
class Output extends Field{
	public $bDoc = false;
	protected $strBase = 'Output';
	protected $arrUse = array('Utils\Tool\Validator\Field');
	public function getFieldConfig($p_pFunction) {
		return $this->parseReturn($p_pFunction);
	}
	public function genFunctionParams($p_pFunction){
		return array('$p_mxData');
	}
}