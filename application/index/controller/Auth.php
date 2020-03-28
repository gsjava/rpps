<?php
namespace app\index\controller;
use think\Controller;
use think\Session;


class Auth extends Controller{
    /**
     * @api 校验Session是否过期
     * @return bool
     */
    public static function sessionExpire(){
        if (Session::has('user_id')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @api 获取当前Session所有数据
     * @return array
     */
    public static function getSession(){
        $session = ['user_id'=>Session::get('user_id'),'real_name'=>Session::get('real_name'),'department'=>Session::get('department')];
        return $session;
    }

    /**
     * @api 获取SessionID
     * @return mixed
     */
    public static function  getSessionUserId(){
        return Session::get('user_id');
    }
}