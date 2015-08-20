<?php
namespace Utils\Tool\Generator;
use Utils\Tool\Generator\Base;
class Test extends Base{
	public $bDoc = false;
	protected $strBase = '';
	protected $strExtend = "\PHPUnit_Framework_TestCase";
	protected $strPrefix = 'test';
	protected $bUpper = true;
	protected $strClassPost = 'Test';
	protected $strClassPrefix = 'Test';
	public function genCustom(){
		$strContent = '';
		$strContent .= '	public $pObj = null;'.PHP_EOL;
		$strContent .= '	public function __construct(';
		$strContent .='){'.PHP_EOL;
		$strContent .='		$this->pObj = new '.$this->strServiceName.'();'.PHP_EOL;
		$strContent .='	}'.PHP_EOL;
		return $strContent;
	}
	public function genFunctionContent($p_pFunction){
		$arrAssert = $this->parseAssert($p_pFunction);
		$strContent = '';
		if(empty($arrAssert)){
			$strContent .= '		$this->assertTrue(false);'.PHP_EOL;
		}
		else{
			foreach ($arrAssert as $k => $v){
				$strContent .= '		$this->'.$v[0].'$this->pObj->'.$p_pFunction->getName().'('.$v[1].')'.$v[2].';'.PHP_EOL;
			}
		}
		return $strContent;
	}
	public function genFunctionParams($p_pFunction){
		return '';
	}
}