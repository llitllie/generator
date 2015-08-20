<?php
namespace Utils\Tool\Generator;
class Input extends Field{
	public $bDoc = false;
	protected $strBase = 'Input';
	protected $arrUse = array('Utils\Tool\Validator\Field');
	public function getFieldConfig($p_pFunction) {
		return $this->parseValid($p_pFunction);
	}
}