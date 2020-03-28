<?php
namespace app\index\controller;
use think\Session;
use app\index\controller\Auth;	//引入基类
use app\index\model\User as UserModel;
class Index extends Auth
{
    /**
     * Session授权接口
     */
    public function initSessionService(){
        if ($_GET['token'] == 'rpps'){
            if ($this::sessionExpire()){
                $result = ['code'=>'200','msg'=>'访问者授权成功','data'=>null];
            } else {
                $result = ['code'=>'101','msg'=>'登录超时,请重新登录系统','data'=>null];
            }
        } else {
            $result = ['code'=>'505','msg'=>'非法访问','data'=>null];
        }
        echo json_encode($result);
    }

    public function index()
    {
        return view();
    }

    /**
     * 退出登录接口
     */
    public function  exitLoginService(){
        if (trim($_GET['token'])){
            //清空当前Session
            Session::clear();
            $result = ['code'=>'200','msg'=>'请求成功','data'=>true];
            echo json_encode($result);
        }
    }

    /**
     * [loginService 登录请求接口]
     * @return [Json]
     */
    public function loginService(){
    	$login_name = trim($_GET['uname']);
    	$password = md5(trim($_GET['upass']));
    	$DBUser = new UserModel();
    	$result = $DBUser::loginImpl($login_name,$password);
    	if ($result) {
    		$if_del = $result['if_del'];
    		$state = $result['state'];
    		if($if_del){
                $result = ['code'=>'202','msg'=>'认证失败：(用户不存在，请联系管理员)','data'=>null];
                echo json_encode($result);
            } elseif($state){
                $result = ['code'=>'203','msg'=>'认证失败：(您的账号已被禁用，请联系管理员)','data'=>null];
                echo json_encode($result);
            } else {
    		    //登录成功
                session('user_id',$result['user_id']);
                session('department',$result['department']);
                session('real_name',$result['real_name']);
                $result = ['code'=>'200','msg'=>'认证成功，欢迎登录甘肃精神卫生管理平台。正在跳转，请稍等~~~','data'=>true];
                echo json_encode($result);
            }
    	} else {
    	    //用户不存在
    		$result = ['code'=>'201','msg'=>'认证失败：(登录名或密码错误，请联系管理员)','data'=>false];
            echo json_encode($result);
    	}
    }

    public function urlService()
    {
    	/*if (trim(empty($_GET['is_success']))) {
    		// $this->redirect('/index/index/home');
    		// $this->success('ok','index/index/home');
    		// header("Location: url('index/index/home')");
    		$result = ['data' => true,'code'=> '10001','msg' => '接口调用成功'];
    	}*/
    	$result = ['data' => true,'code'=> '10001','msg' => '接口调用成功'];
    	echo json_encode($result);
    }

    public function rpps()
    {
    	return view();
    }

    public function home()
    {
    	return view();
    }


}
