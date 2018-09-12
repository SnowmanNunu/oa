<?php
namespace app\admin\controller;
use think\Controller;
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
 		dump($data);
 		$this->check(input('code'));
 		if ($data['password']==md5($data['password'])) {
		    session('name',$data['name']);
		    $this->success('登录成功！',url('Login/index'));
 		}else{
 			$this->success('登录失败！',url('Login/index'));
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
