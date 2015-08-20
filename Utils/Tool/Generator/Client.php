<?php
namespace Utils\Tool\Generator;
use Utils\Tool\Generator\Base;
use Utils\Tool\Parser\ReflectFunction;
class Client extends Base{
	public $bDoc = true;
	protected $strBase = 'Client';
	protected $arrUse = array('Mars\Client\RPC\Service');
	protected $strExtend = "Service";
	public function genFunctionContent($p_pFunction) {
		$strContent = '';
		$strContent .='		return $this->pRPC->'.$this->strPrefix.$p_pFunction->getName().'(';
		$arrParams = $p_pFunction->getParams(ReflectFunction::PARAM_WITHOUT_DEFAULT);
		if(!empty($arrParams)){
			$strContent .= implode(',', $arrParams);
		}
		$strContent .= ');'.PHP_EOL;
		return $strContent;
	}
	public function afterGenFunction($p_pFunction){
		$strContent = '';
		$this->bDoc = false;
		$this->strPrefix = 'send_';
		$strContent .= $this->genFunction($p_pFunction);
		$this->strPrefix = 'recv_';
		$strContent .= $this->genFunction($p_pFunction);
	
		$this->strPrefix = '';
		$this->bDoc = true;
		return $strContent;
	}
	public function genCustom(){
		$strContent = '';
		$strContent .= '	public $strService = '.$this->strServiceName.';'.PHP_EOL;
		return $strContent;
	}
}