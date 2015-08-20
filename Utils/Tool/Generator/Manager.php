<?php
namespace Utils\Tool\Generator;
class Manager{
	public static $arrMap = array(
			'-i' => '\Utils\Tool\Generator\Input',
			'-o' => '\Utils\Tool\Generator\Output',
			'-t' => '\Utils\Tool\Generator\Test',
			'-c' => '\Utils\Tool\Generator\Client',
			'-d' => '\Utils\Tool\Generator\DefaultResult'
	);
	public static function configurate($p_arrMap){
		if(is_array($p_arrMap)){
			self::$arrMap = array_merge(self::$arrMap , $p_arrMap);
		}
	}
	public static function gen($p_argv){
		//$strCmd = "gen.php -f -a -i -c -o -d -s -t \\\\Cloud\\\\KSongMatch\\\\Prize\\\\Service";
		$nLen = count($p_argv);
		$arrGen = array();
		$strClassName = '';
		$bForce = false;
		for($i = 1; $i < $nLen; $i++){
			if(strpos($p_argv[$i], '-') !== false){
				switch($p_argv[$i]){
					case '-f':
						$bForce = true;
						break;
					case '-a':
						$bAsync = true;
						break;
					default:
						$arrGen[] = $p_argv[$i];
						break;
				}
			}
			else{
				$strClassName = $p_argv[$i];
			}
		}
		if(empty($strClassName)){
			self::error('Class Name Should Not Be Empty');
		}
		if(empty($arrGen)){
			self::error('Class Name Should Not Be Empty');
		}
		foreach ($arrGen as $v){
			if(isset(self::$arrMap[$v])){
				$strGen = self::$arrMap[$v];
				$pGenerator = new $strGen($strClassName);
				if(!$bForce && $pGenerator->isFileExist()){
					echo "File already exist  ".PHP_EOL;
					echo "use -f to force generate ".PHP_EOL;
					exit();
				}
				$pGenerator->genClass();
				$pGenerator->save();
			}
		}
	}
	public static function error($p_strError){
		echo $p_strError.PHP_EOL;
		self::useage();
	}
	public static function useage(){
		echo 'USEAGE : gen.php [option] <service> '.PHP_EOL;
		echo 'optoin '.PHP_EOL;
		echo '	-i generate input'.PHP_EOL;
		echo '	-o generate output'.PHP_EOL;
		echo '	-c generate client'.PHP_EOL;
		echo '	-s generate service'.PHP_EOL;
		echo '	-d generate default'.PHP_EOL;
		echo '	-t generate test'.PHP_EOL;
		echo '	-f forece generate'.PHP_EOL;
		echo '	-a generate async'.PHP_EOL;
		echo '	-fn generate fuction'.PHP_EOL;
		echo 'eg. gen.php -f -a \\\\Cloud\\\\KSongMatch\\\\Prize\\\\Service'.PHP_EOL;
		exit();
	}
	public static function useforce(){
		echo "File already exist  ".PHP_EOL;
		echo "use -f to force generate ".PHP_EOL;
		exit();
	}
}