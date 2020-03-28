<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Db;
use app\index\model\User as UserModel;

class User extends Auth{

	/**
	 * [ulist 用户列表]
	 * @return [type] [用户视图]
	 */
	public function ulist(){
		$jdbc = new UserModel();
		$result = $jdbc::initUserDateImpl();
		$usertype = $jdbc::getUsertypeDic();
		$usernum = $jdbc::getUserNum();
		$rownum = 1;
		$this->assign('result',$result);
		$this->assign('rownum',$rownum);
		$this->assign('usertype',$usertype);
		$this->assign('usernum',$usernum);
		return view();
	}

	/**
	 * [utype 角色管理]
	 * @return [type] [角色视图]
	 */
	public function utype(){
		$db = new UserModel();
		$rolenum = $db::getRoleNum();
		$userlist = $db::getUtypeList();
		$this->assign('userlist',$userlist);
		$this->assign('rolenum',$rolenum);
		return view();
	}

	/**
	 * [initUserDateService 初始化用户信息接口]
	 * @return [type] [接口]
	 */
	public function initUserDateService(){
		if (trim($_GET['token']) == '62090220198866') {
			$jdbc = new UserModel();
			$result = $jdbc::initUserDateImpl();
			if ($result) {
				$data = ['code'=>'200','msg'=>'获取用户信息成功!','data'=>null];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [see 查看个案用户接口]
	 * @return [type] [个案用户视图]
	 */
	public function see(){
		if (!empty($_GET['user_id'])) {
			$user_id = $_GET['user_id'];
			$db = new UserModel();
			$result = $db::getUserInfoService($user_id);
			$this->assign('result',$result);
		}
		return view();
	}

	/**
	 * [edit 编辑获取用户信息]
	 * @return [type] [编辑视图]
	 */
	public function edit(){
		$db = new UserModel();
		$user_id = $_GET['user_id'];
		$data = $db::getEditUser($user_id);
		$this->assign('data',$data);
		return view();
	}


	public function editUserInfoService(){
		$login_name = trim($_GET['login_name']);
		$real_name = trim($_GET['real_name']);
		$department = trim($_GET['department']);
		$phone_number = trim($_GET['phone_number']);
		$user_id = trim($_GET['user_id']);
		if ($login_name && $real_name && $department && $user_id && $phone_number) {
			$password = md5($phone_number);
			$data = [
				'login_name'	=>	$login_name,
				'real_name'		=>	$real_name,
				'department'	=>	$department,
				'phone_number'	=>	$phone_number,
				'password'		=>	$password
			];
			$db = new UserModel();
			$result = $db::editUserInfoImpl($data,$user_id);
			if ($result) {
				$data = ['code'=>'200','msg'=>'更新成功','data'=>$result];
			} else {
				$data = ['code'=>'505','msg'=>'未做任何修改','data'=>false];
			}
		} else {
			$data = ['code'=>'201','msg'=>'更新失败：(数据项不完整,请检查上传的数据项)','data'=>false];
		}	
		echo json_encode($data);
	}

	/**
	 * [userStartService 用户启用]
	 * @return [type] [json]
	 */
	public function userStartService(){
		$user_id = $_GET['token'];
		$db = new UserModel();
		$result = $db::userStartImpl($user_id);
		if ($result) {
			$data = ['code'=>'200','msg'=>'已启用','data'=>$result];	
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>$result];
		}
		echo json_encode($data);
	}

	/**
	 * [userStartService 用户禁用]
	 * @return [type] [json]
	 */
	public function userStopService(){
		$user_id = $_GET['token'];
		$db = new UserModel();
		$result = $db::userStopImpl($user_id);
		if ($result) {
			$data = ['code'=>'200','msg'=>'已禁用','data'=>$result];	
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>$result];
		}
		echo json_encode($data);
	}

	/**
	 * [initzonecodeService 获取初始化省级地区信息接口]
	 * @return [type] [json]
	 */
	public function initzonecodeService(){
		if (trim($_GET['token'] == '62000000')) {
			$mapp = new UserModel();
			$result = $mapp::initzonecodeImpl();
			if ($result) {
				$data = ['code'=>'200','msg'=>'获取省级地区信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [initcityService 获取初始化市州级地区信息接口]
	 * @return [type] [json]
	 */
	public function initcityService(){
		if (trim($_GET['token'] == '6201000000')) {
			$db = new UserModel();
			$result = $db::initcityImpl();
			if ($result) {
				$data = ['code'=>'200','msg'=>'获取市州地区信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [initcountyService 获取初始化区县级地区信息接口]
	 * @return [type] [json]
	 */
	public function initcountyService(){
		if (trim($_GET['token'] == '6201020000')) {
			$db = new UserModel();
			$result = $db::initcountyImpl();
			if ($result) {
				$data = ['code'=>'200','msg'=>'获取区县地区信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [initorgService 获取初始化区县级机构信息接口]
	 * @return [type] [json]
	 */
	public function initorgService(){
		if (trim($_GET['token'] == '620102000')) {
			$db = new UserModel();
			$result = $db::initorgyImpl();
			if ($result) {
				$data = ['code'=>'200','msg'=>'获取区县机构信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [synczonecodeService 动态获取区县地区信息接口]
	 * @return [type] [json]
	 */
	public function synczonecodeService(){
		if (!empty(trim($_GET['zonecode']))) {
			$zonecode = substr(trim($_GET['zonecode']), 0,4) . '%';
			$db = new UserModel();
			$result = $db::synczonecodeImpl($zonecode);
			if ($result) {
				$data = ['code'=>'200','msg'=>'动态获取区县地区信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [syncorgcodeService 动态获取市州机构信息接口]
	 * @return [type] [json]
	 */
	public function syncorgcodeService(){
		if (!empty(trim($_GET['zonecode']))) {
			$orgcode = substr(trim($_GET['zonecode']), 0,4) . '%';
			$db = new UserModel();
			$result = $db::syncorgcodeImpl($orgcode);
			if ($result) {
				$data = ['code'=>'200','msg'=>'动态获取市州机构信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [syncorgcodeServices 动态获取区县机构接口]
	 * @return [type] [json]
	 */
	public function syncorgcodeServices(){
		if (!empty(trim($_GET['zonecode']))) {
			$orgcode = substr(trim($_GET['zonecode']), 0,6) . '%';
			$db = new UserModel();
			$result = $db::syncorgcodeImpls($orgcode);
			if ($result) {
				$data = ['code'=>'200','msg'=>'动态获取区县机构信息成功!','data'=>$result];	
			} else {
				$data = ['code'=>'301','msg'=>'请求资源不存在!','data'=>null];
			}
			echo json_encode($data);
		} else {
			$data = ['code'=>'505','msg'=>'服务器错误,请联系管理员!','data'=>null];
			echo json_encode($data);
		}
	}

	/**
	 * [insertUaamsUser 新增用户接口]
	 * @return [type] [josn]
	 */
	public function insertUaamsUser(){
		$zonecode = trim($_GET['zonecode']);
		$orgcode = trim($_GET['orgcode']);
		$login_name = trim($_GET['login_name']);
		$real_name = trim($_GET['real_name']);
		$usertype = trim($_GET['usertype']);
		$telphone = trim($_GET['telphone']);
		$department = trim($_GET['department']);
		if (!empty($zonecode) && !empty($orgcode) && !empty($login_name) && !empty($real_name) && !empty($usertype) && !empty($telphone) && !empty($department)) {
			if ($usertype == '2' || $usertype == '3') {
				$create_date = date('Y-m-d');
				$password = md5($telphone);
				$data = [
					'zonecode'		=>		$zonecode,
					'orgcode'		=>		$orgcode,
					'login_name'	=>		$login_name,
					'password'		=>		$password,
					'real_name'		=>		$real_name,
					'usertype'		=>		$usertype,
					'phone_number'	=>		$telphone,
					'department'	=>		$department,
					'create_date'	=>		$create_date
				];
				$db = new UserModel();
				$result = $db::insertUaamsUserImpl($data);
				if ($result) {
					$uaamsUser = $db::getInsertData($result);
					$data = ['code'=>'200','msg'=>"新用户创建成功！以下登录信息请您妥善保管（登录名：{$uaamsUser['login_name']}；密码：{$uaamsUser['phone_number']}；创建日期：{$uaamsUser['create_date']}）",'data'=>$data];	
					echo json_encode($data);
				} else {
					$data = ['code'=>'301','msg'=>'服务器操作,请联系管理员!','data'=>null];
					echo json_encode($data);
				}
			} else {
				$data = ['code'=>'203','msg'=>'用户类型越界,只允许选择直报或本级用户!','data'=>null];
				echo json_encode($data);
			}
		} else {
			$data = ['code'=>'202','msg'=>'用户信息不完整,请检查数据项!','data'=>null];
			echo json_encode($data);
		}
	}

}