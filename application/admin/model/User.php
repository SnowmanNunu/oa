<?php
namespace app\admin\model;
use think\Model;


class Admin extends Model
{
	public function login($data){
		$admin = Admin::getByName($data['name']);

		if ($admin) {
			if ($admin['password']==md5($data['password'])) {
				session('id',$admin['id']);
				session('name',$admin['name']);
				return 2;    //登录密码正确
			}else{
				return 3;    //密码错误
			}
		}else{
			return 1;       //用户不存在
		}
	}


}