<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Email as myEmail;


class Email extends Controller
{
	public function send()
	{
		if (request()->isPost()) {
		$data = input('post.');
		$email = new myEmail();

		// 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('file');
    
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

		// dump($file);
		// $result = $email->up(Request,$_FILES['file']);
		// dump($result);
		}
		return $this->fetch();
	}

	public function sendBox()
	{
		return $this->fetch();
	}


	public function recBox()
	{
		return $this->fetch();
	}




}