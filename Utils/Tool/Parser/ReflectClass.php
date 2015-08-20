<?php
namespace Utils\Tool\Parser;
use Utils\Tool\Parser\ReflectFunction;
class ReflectClass{
	public $strClassName = '';
	public $arrFunction = array();
	public function __construct($p_strClassName){
		$this->strClassName = $p_strClassName;
	}
	public function parse(){
		//TODO 要考虑继承
		$pClass = new \ReflectionClass($this->strClassName);
		$arrMethod = $pClass->getMethods();
		if(empty($arrMethod)){
			return false;
		}
		foreach ($arrMethod as $pMethod){
			//TODO static呢
			if($pMethod->isPublic()){
				$strFuncName = $pMethod->getName();
				$arrParam = $pMethod->getParameters();
				$arrPars = array();
				$arrParm = array();
				if(!empty($arrParam)){
					foreach ($arrParam as $pParam){
						$strPars = $strParm = '$';
						$strPars = $strParm.= $pParam->getName();
						if($pParam->isOptional()){
							//TODO 类常量的传递会有问题
							$strPars.= ' = '.$pParam->getDefaultValue();
						}
						$arrPars[] = $strPars;
						$arrParm[] = $strParm;
					}
				}
				$strDoc = $pMethod->getDocComment();
				$this->arrFunction[] = new ReflectFunction($strFuncName, array($arrParm, $arrPars), $strDoc);
			}
		}
		return $this->arrFunction;
	}
	public function getFuncionList(){
		return $this->arrFunction;
	}
}