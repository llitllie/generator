<?php
namespace Utils\Tool\Parser;
class ReflectFunction{
	public $strFunctionName = '';
	public $arrParams = array();
	public $strDoc = '';
	const PARAM_WITH_DEFAULT = 1;
	const PARAM_WITHOUT_DEFAULT = 0;
	public function __construct($p_strFuntionName, $p_arrParams, $p_strDoc){
		$this->strFunctionName = $p_strFuntionName;
		$this->arrParams = $p_arrParams;
		$this->strDoc = $p_strDoc;
	}
	public function getParams($p_nType = self::PARAM_WITH_DEFAULT){
		if(empty($this->arrParams) || count($this->arrParams) != 2){
			return false;
		}
		if($p_nType == self::PARAM_WITHOUT_DEFAULT){
			return $this->arrParams[0];
		}
		else{
			return $this->arrParams[1];
		}
	}
	public function getDoc($p_strKey = ''){
		if($p_strKey == ''){
			return $this->strDoc;
		}
		//TODO 整行获取
		$nMatch = preg_match_all("/(".$p_strKey.").{0,}/", $this->strDoc, $arrMatch);
		if($nMatch > 0){
			return $arrMatch[0];
		}
		else{
			return array();
		}
	}
	public function getName($p_strPrefix = '', $p_bUpper = false){
		$strName = $p_bUpper ? ucwords($this->strFunctionName) : $this->strFunctionName;
		return $p_strPrefix.$strName;
	}
	public function getContent(){
	
	}
}