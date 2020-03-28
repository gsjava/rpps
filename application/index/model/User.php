<?php
namespace app\index\model;
use think\Model;
use think\Db;

class User extends Model
{
    /**
     * [loginImpl 登录校验查询方法]
     * @param  [type] $login_name [登录名]
     * @param  [type] $password   [密码]
     * @return [type]             [boolean]
     */
	public static function loginImpl($login_name,$password){
		$result = Db::name('user')->where(['login_name'=>$login_name,'password'=>$password])->select();
		if ($result) {
			return $result[0];
		} else {
			return false;
		}
	}

	/**
	 * [initUserDateImpl 查询初始化用户信息方法]
	 * @return [type] [Array]
	 */
	public static function initUserDateImpl(){
		$result = Db::table('userlist')->select();
		return $result;
	}

	/**
	 * [initzonecodeImpl 查询初始化地区信息方法]
	 * @return [type] [Array]
	 */
	public static function initzonecodeImpl(){
		$result = Db::table('com_zonecode')->field('zonecode,cnname')->where(['zonelevel'=>'1','years'=>'2019'])->order('zonecode asc')->select();
		return $result;
	}

	/**
	 * [initcityImpl 查询初始化市州级地区信息方法]
	 * @return [type] [Array]
	 */
	public static function initcityImpl(){
		$result = Db::table('com_zonecode')->field('zonecode,cnname')->where(['zonelevel'=>'2','years'=>'2019'])->order('zonecode asc')->select();
		return $result;
	}

	/**
	 * [initcountyImpl 查询初始化区县级地区信息方法]
	 * @return [type] [Array]
	 */
	public static function initcountyImpl(){
		$result = Db::table('com_zonecode')->field('zonecode,cnname')->where(['zonelevel'=>'3','years'=>'2019'])->whereLike('zonecode','6201%')->order('zonecode')->select();
		return $result;
	}

	/**
	 * [initorgyImpl 查询初始化机构信息方法]
	 * @return [type] [Array]
	 */
	public static function initorgyImpl(){
		$result = Db::table('mh_orgcode')->field('orgcode,orgname')->where(['sub'=>'1','years'=>'2019'])->whereLike('orgcode','6201%')->order('orgcode')->select();
		return $result;
	}

	/**
	 * [synczonecodeImpl 查询动态地区信息方法]
	 * @param  [type] $zonecode [地区编码]
	 * @return [type]           [Array]
	 */
	public static function synczonecodeImpl($zonecode){
		$result = Db::table('com_zonecode')->field('zonecode,cnname')->where(['zonelevel'=>'3','years'=>'2019'])->whereLike('zonecode',$zonecode)->order('zonecode')->select();
		return $result;
	}

	/**
	 * [syncorgcodeImpl 查询动态机构信息方法]
	 * @param  [type] $orgcode [机构编码]
	 * @return [type]          [Array]
	 */
	public static function syncorgcodeImpl($orgcode){
		$result = Db::table('mh_orgcode')->field('orgcode,orgname')->where(['sub'=>'2','years'=>'2019'])->whereLike('orgcode',$orgcode)->order('orgcode')->select();
		return $result;
	}

	/**
	 * [syncorgcodeImpls 查询动态机构信息方法]
	 * @param  [type] $orgcode [机构编码]
	 * @return [type]          [Array]
	 */
	public static function syncorgcodeImpls($orgcode){
		// $result = Db::table('mh_orgcode')->field('orgcode,orgname')->where(['years'=>'2019'])->whereLike('orgcode',$orgcode)->where('sub','in',[3,4,5])->order('orgcode')->select();
		$result = Db::table('mh_orgcode')->field('orgcode,orgname')->where(['years'=>'2019'])->whereLike('orgcode',$orgcode)->where('sub',['=','3'],['=','4'],['=','5'],'or')->order('orgcode')->select();
		return $result;
	}

	/**
	 * [getUsertypeDic 查询用户类型字典方法]
	 * @return [type] [Array]
	 */
	public static function getUsertypeDic(){
		$result = Db::table('t_rpps_dic_usertype')->field('code,name,no')->order('no')->select();
		return $result;
	}

	/**
	 * [insertUaamsUserImpl 新增用户方法]
	 * @param  [type] $data [封装的用户数据]
	 * @return [type]       [Array]
	 */
	public static function insertUaamsUserImpl($data){
		$result = Db::name('user')->insertGetId($data);
		return $result;
	}

	/**
	 * [getInsertData 新增成功查询登录名、密码和创建日期方法 反馈客户需要]
	 * @param  [type] $result [用户ID]
	 * @return [type]         [Array]
	 */
	public static function getInsertData($result){
		$result = Db::name('user')->field('login_name,phone_number,create_date')->where(['user_id'=>$result])->find();
		return $result;
	}

	/**
	 * [getUserInfoService 获取个案用户信息]
	 * @param  [type] $user_id [用户ID]
	 * @return [type]          [Array]
	 */
	public static function getUserInfoService($user_id){
		$result = Db::table('usercase')->where(['user_id'=>$user_id])->select();
		return $result;
	}

	/**
	 * [userStartImpl 用户启用]
	 * @param  [type] $user_id [用户ID]
	 * @return [type]          [影响数据的条数]
	 */
	public static function userStartImpl($user_id){
		$result = Db::name('user')->where('user_id',$user_id)->setField('state','0');
		return $result;
	}

	/**
	 * [userStartImpl 用户禁用]
	 * @param  [type] $user_id [用户ID]
	 * @return [type]          [影响数据的条数]
	 */
	public static function userStopImpl($user_id){
		$result = Db::name('user')->where('user_id',$user_id)->setField('state','1');
		return $result;
	}

	/**
	 * [getEditUser 编辑查询用户信息]
	 * @return [type] [Array]
	 */
	public static function getEditUser($user_id){
		$result = Db::table('usercase')->where('user_id',$user_id)->select();
		return $result;
	}

	/**
	 * [editUserInfoImpl 更新用户信息]
	 * @param  [type] $data    [更新的数据]
	 * @param  [type] $user_id [用户ID]
	 * @return [type]          [Int]
	 */
	public static function editUserInfoImpl($data,$user_id){
		$result = Db::name('user')->where('user_id',$user_id)->update($data);
		return $result;
	}

	/**
	 * [getUserNum 查询用户数量]
	 * @return [type] [Array]
	 */
	public static function getUserNum(){
		$result = Db::table('bsp_queryconfig')->where('code','usernum')->field('querysql')->find()['querysql'];
		$data = Db::query($result);
		return $data;
	}

	/**
	 * [getRoleNum 查询角色名及对应的数量]
	 * @return [type] [Array]
	 */
	public static function getRoleNum(){
		$result = Db::table('bsp_queryconfig')->where('code','rolenum')->field('querysql')->find()['querysql'];
		$data = Db::query($result);
		return $data;
	}


	public static function getUtypeList(){
		$result = Db::table('usercase')->select();
		return $result;
	}
}

