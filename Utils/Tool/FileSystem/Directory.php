<?php
namespace Utils\Tool\FileSystem;
class Directory{
	public static function create($p_strDir, $p_strMode = 0777){
		if (is_dir($p_strDir) || @mkdir($p_strDir, $p_strMode)) return true;
		if (!call_user_func_array(array('KM\Tool\FileSystem\Directory', 'Create'), array(dirname($p_strDir), $p_strMode))) return false;
		return @mkdir($p_strDir, $p_strMode);
	}
}