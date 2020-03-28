<?php
namespace app\index\controller;
use think\Session;
use app\index\controller\Auth;	//引入基类
use app\index\model\Assess as AssessModel;

class Assess extends Auth{
	public function standardreport(){
		//字典遍历
		$db = new AssessModel();
		$standard = $db::getStandard();
		$assess = $db::getAssess();
		$this->assign('standard',$standard);
		$this->assign('assess',$assess);
		return view();
	}
}