<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
// use think\Session;
// use think\Db;
//use think\captcha\Captcha;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

 	
 	public function checkLogin()
 	{
 		if (request()->isPost()) {
 		$data = input('post.');
 		$this->check(input('code'));
 		$admin=new User();
        $num=$admin->login($data);
        if($num==3){
            $this->success('信息正确，正在为您跳转...',url('index/index'));
        }elseif($num==1){
                $this->error('用户不存在');
        }else{
            $this->error('密码错误');
        }
 		}
 		
 	}

 	// 验证码检测
        public function check($code){

        if (!captcha_check($code)) {
        $this->error('验证码错误');
        } else {
        return true;
        }
    }
}
