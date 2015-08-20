<?php
namespace Utils\Tool\Validator;
class Field{
	const REGX_LESS = 2;
	const REGX_EQUAL = 4;
	const REGX_GREAT = 8;
	public $mxValue = null;
	public $arrConfig = array();
	public function __construct($p_mxValue, $p_arrConfig){
		$this->mxValue = $p_mxValue;
		$this->arrConfig = $p_arrConfig;
	}
	public function valid(){
		if(empty($this->arrConfig)){
			return false;
		}
		foreach($this->arrConfig as $k => $v){
			call_user_func_array(array($this, $k), $v);
		}
	}
	public function type(){
		if(!isset($this->arrConfig['type'])){
			return false;
		}
		$strType = $this->arrConfig['type'];
		if($strType == 'mixed'){
			return true;
		}
		if(strpos($strType, '|')){
			$bRes = false;
			$arrType = explode('|', $strType);
			foreach ($arrType as $strType){
				if($this->_validType($strType)){
					$bRes = true;
					break;
				}
			}
			if(!$bRes){
				return false;
			}
		}
		return true;
	}
	private function _validType($p_strType){
		$bRes = false;
		switch ($p_strType){
			case "integer":
				$bRes = $this->_validInteger();
				break;
			case "boolean":
				$bRes = $this->_validBoolean();
				break;
			case "array":
				$bRes = $this->_validArray();
				break;
			case "string":
				$bRes = $this->_validString();
				break;
			case "double":
				break;
				$bRes = $this->_validDouble();
			default:
				//TODO ClassName怎么办
				break;
		}
		return $bRes;
	}
	private function _validInteger(){
		return is_integer($this->mxValue);
	}
	private function _validString(){
		//TODO 字符串默认长度，不能带特殊字符，编码及平台问题
		return is_string($this->mxValue) && (strpos($this->mxValue, 'select') === false);
	}
	private function _validBoolean(){
		return is_bool($this->mxValue);
	}
	private function _validArray(){
		return is_array($this->mxValue);
	}
	private function _validDouble(){
		return is_double($this->mxValue);
	}
	public function max($p_nMax){
		if($this->mxValue > $p_nMax){
			return false;
		}
		return true;
	}
	public function min($p_nMin){
		if($this->mxValue < $p_nMin){
			return false;
		}
		return true;
	}
	public function enum($p_arrEnum){
		if(in_array($this->mxValue, $p_arrEnum)){
			return true;
		}
		return false;
	}
	public function maxLen($p_nLength){
		if(strlen($this->mxValue) > $p_nLength){
			return false;
		}
		return true;
	}
	public function minLen($p_nLength){
		if(strlen($this->mxValue) < $p_nLength){
			return false;
		}
		return true;
	}
	public function contain($p_mxContain){
		if(strpos($this->mxValue, $p_mxContain)){
			return true;
		}
		return false;
	}
	public function regex($p_strPatten, $p_nMatch, $p_nType = self::REGX_EQUAL ){
		$nMatch = preg_match_all($p_strPatten, $this->mxValue);
		$bRes = false;
		switch ($p_nType){
			case self::REGX_LESS:
				$bRes = ($p_nMatch < $nMatch) ? true : false;
				break;
			case self::REGX_EQUAL:
				$bRes = ($p_nMatch == $nMatch) ? true : false;
				break;
			case self::REGX_EQUAL|self::REGX_LESS:
				$bRes = ($p_nMatch <= $nMatch) ? true : false;
				break;
			case self::REGX_GREAT:
				$bRes = ($p_nMatch > $nMatch) ? true : false;
				break;
			case  self::REGX_EQUAL|self::REGX_GREAT:
				$bRes = ($p_nMatch >= $nMatch) ? true : false;
				break;
		}
		return $bRes;
	}
}