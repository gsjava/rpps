<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Assess extends Model{

	public static function getStandard(){
		$result = Db::table('t_rpps_dic_standard')->order('no')->select();
		return $result;
	}


	public static function getAssess(){
		$result = Db::table('t_rpps_dic_assess')->order('no')->select();
		return $result;
	}
}