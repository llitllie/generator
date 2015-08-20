<?php
namespace Utils\Tool\Generator;
use Utils\Tool\Parser\ReflectClass;
use Utils\Tool\Parser\ReflectFunction;
use Utils\Tool\FileSystem\Directory;
abstract class Base{
	public $strServiceName = '';
	public $strNameSpace = '';
	public $strShortName = '';
	public $bDoc = false;
	protected $strBase = '';
	protected $arrUse = array();
	protected $arrProp = array();
	protected $strExtend = '';
	protected $strPrefix = '';
	protected $bUpper = false;
	protected $strClassPost = '';
	protected $strClassPrefix = '';
	public $strFileName = '';
	public $strFilePath = '';
	public $strContent = '';
	public function __construct($p_strClassName){
		$this->strServiceName = $p_strClassName;
		$arrClassName = explode('\\', trim($p_strClassName, '\\'));
	
		if(!empty($this->strBase)){
			$arrClassName[0] = $this->strBase;
		}
		if(!empty($this->strClassPrefix)){
			array_unshift($arrClassName, $this->strClassPrefix);
		}
	
		$this->strShortName =array_pop($arrClassName);
		if(!empty($this->strClassPost)){
			$this->strShortName .= $this->strClassPost;
		}
		$this->strNameSpace = implode('\\', $arrClassName);
	
		$this->strFilePath = ROOT_PATH.implode(DIRECTORY_SEPARATOR, $arrClassName);
		$this->strFileName = $this->strFilePath.DIRECTORY_SEPARATOR.$this->strShortName.'.php';
	}
	public function genClass(){
		$this->strContent = "<?php".PHP_EOL;
		$this->strContent .= "namespace ".$this->strNameSpace.";".PHP_EOL;
	
		$this->strContent .= $this->genUseClass();
		$this->strContent .= "class ".$this->strShortName;
		if(!empty($this->strExtend)){
			$this->strContent .= " extends ".$this->strExtend;
		}
		$this->strContent .= " {".PHP_EOL;
		$this->strContent .= $this->genPropoty();
		$this->strContent .= $this->genCustom();
		$this->strContent .= $this->genFunctionList();
		$this->strContent .= "}".PHP_EOL;
	}
	public function genUseClass(){
		$strUse = '';
		if(!empty($this->arrUse)){
			foreach ($this->arrUse as $v){
				$strUse .= "use $v;".PHP_EOL;
			}
		}
		return $strUse;
	}
	public function genPropoty(){
		$strPro = '';
		if(!empty($this->arrProp)){
			foreach ( $this->arrProp as $k => $v){
				$strPro .= "	public $".$k;
			}
		}
		return $strPro;
	}
	public function beforeGenFunction($pFunction){
		return '';
	}
	public function afterGenFunction($pFunction){
		return '';
	}
	public function genCustom(){
	
	}
	public function genFunctionList(){
		$pReflect = new ReflectClass($this->strServiceName);
		$arrFunction = $pReflect->parse();
		$strContent = '';
		if(!empty($arrFunction)){
			foreach ($arrFunction as $pFunction){
				$strContent .= $this->beforeGenFunction($pFunction);
				$strContent .= $this->genFunction($pFunction);
				$strContent .= $this->afterGenFunction($pFunction);
			}
		}
		return $strContent;
	}
	public function genFunction($p_pFunction){
		$strContent = '';
		if($this->bDoc){
			$strContent .= '	'.$p_pFunction->getDoc().PHP_EOL;
		}
		$strContent .= '	public function '.$p_pFunction->getName($this->strPrefix, $this->bUpper).'(';
		$arrParams = $this->genFunctionParams($p_pFunction);
		if(!empty($arrParams)){
			$strContent .= implode(',', $arrParams);
		}
		$strContent .='){'.PHP_EOL;
		$strContent .= $this->genFunctionContent($p_pFunction);
		$strContent .='	}'.PHP_EOL;
		return $strContent;
	}
	public abstract function genFunctionContent($p_pFunction);
	public function genFunctionParams($p_pFunction){
		return $p_pFunction->getParams(ReflectFunction::PARAM_WITH_DEFAULT);
	}
	public function parseParam($p_pFunction){
		$arrMatch = $p_pFunction->getDoc('@param');
		$arrParam = array();
		if(!empty($arrMatch)){
				
		}
		return $arrParam;
	}
	private function _parseValid($p_arrMatch, $p_bFieldName = true){
		$arrValid = array();
		if(!empty($p_arrMatch)){
			foreach($p_arrMatch as $strLine){
				$arrLine = explode(" ", trim($strLine), 4);
				$nCount = count($arrLine);
				if($nCount < 2){
					continue;
				}
				$arrConfig["type"] = $arrLine[1];
				$strValid = '';
				$strName = '';
				if($p_bFieldName){
					if($nCount == 4){
						$strName = $arrLine[2];
						$strValid = $arrLine[3];
					}
				}
				else{
					$strName = '$p_mxData';
					if($nCount == 3){
						$strValid = $arrLine[2];
					}
				}
				if(empty($strName)){
					continue;
				}
				$strValid = trim(substr($strValid, 1));
				$arrData = explode(', ', substr($strValid, 5, -1));
				$strKey = $strValue = '';
				$bContinue = false;
				foreach($arrData as $v){
					if(strpos($v, '=')){
						list($strKey, $strValue) = explode('=', $v);
						if(strpos($v, '(') && !strpos($v, ')')){
							//TODO 可能有其他的，比如数组，对象
							$bContinue = true;
						}
					}
					else{
						$strValue .= ','.$v;
						if(strpos($v, ')')){
							$bContinue = false;
						}
					}
					if($bContinue) continue;
					$arrConfig[$strKey] = trim($strValue," \"\'");
					$strValue = '';
				}
				$arrValid[$strName] = $arrConfig;
			}
		}
		return $arrValid;
	}
	public function parseValid($p_pFunction){
		$arrMatch = $p_pFunction->getDoc('@param');
		return $this->_parseValid($arrMatch, true);
	}
	public function parseReturn($p_pFunction){
		$arrMatch = $p_pFunction->getDoc('@return');
		return $this->_parseValid($arrMatch, false);
	}
	public function parseAssert($p_pFunction){
		$arrMatch = $p_pFunction->getDoc('@assert');
		$arrAssert = array();
		if(!empty($arrMatch)){
			foreach($arrMatch as $strAssert){
				$strAssert = trim(substr($strAssert, 1));
				$nStart = strpos($strAssert, '{');
				$nEnd = strpos($strAssert, '}');
				if($nStart && ($nEnd > $nStart)){
					$strHead = substr($strAssert, 0, $nStart);
					$strMiddle = substr($strAssert, $nStart+1, $nEnd-$nStart-1);
					$strTail = substr($strAssert, $nEnd+1);
				}
				else{
					//TODO 不规范写法退出
					//TODO 如果参数为空呢，都不需要呢
					$nStart = strrpos($strAssert, '(');
					$strHead = substr($strAssert, 0, $nStart);
					$strMiddle = '';
					$strTail = substr($strAssert, $nStart+1);
				}
				$arrAssert[] = array($strHead, $strMiddle, $strTail);
			}
		}
		return $arrAssert;
	}
	public function parseDefault($p_pFunction){
		$arrMatch = $p_pFunction->getDoc('@default');
		$mxDefault = '';
		if(!empty($arrMatch)){
			foreach($arrMatch as $strDefault){
				$strDefault = trim(substr($strDefault, 1));
				$nStart = strpos($strDefault, '(');
				$nEnd = strrpos($strDefault, ')');
				if($nStart && ($nEnd > $nStart)){
					$mxDefault = substr($strDefault, $nStart+1, $nEnd-$nStart-1);
				}
				else{
					//TODO 如果是个对象呢
					//$mxDefault = '';
				}
			}
		}
		return $mxDefault;
	}
	public function save(){
		var_dump($this->strFileName);
		if(!is_dir($this->strFilePath)){
			Directory::create($this->strFilePath);
		}
		file_put_contents($this->strFileName, $this->strContent);
	}
	public function isFileExist(){
		return is_file($this->strFileName);
	}
}