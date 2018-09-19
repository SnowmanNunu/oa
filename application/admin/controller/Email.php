<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Email as myEmail;
use think\Db;

class Email extends Controller
{
	public function send()
	{
	$email = new myEmail();
       
	if (request()->isPost()) {
		$data = input('post.');
		$data=array(
            'to_id'=>$data['to_id'],
            'title'=>$data['title'],
            'file'=>$email->upload(),
            'content'=>$data['content'],
            'addtime'=>date('Y-m-d H:i:s')
        );
		$res = db('email')->insert($data);
		if ($res) {
			$this -> success('邮件发送成功！',url('send'),2);
		}else{
			$this -> error('邮件发送失败！');
		}

	}
		$data = $email->recUser();
		$this -> assign('data',$data);
		return $this->fetch();
	}

	public function sendBox()
	{
		$email = new myEmail();
	    $data= $email->sendBox();

		//$this -> assign('counts',$info);
		$this -> assign('data',$data);
		return $this->fetch();
	}


	public function recBox()
	{
		$email = new myEmail();
	    $info= $email->recBox();
		$this -> assign('data',$info);
		return $this->fetch();
	}


	//getCount
	public function getCount(){
			$email = new myEmail();
			$counts = $email->Ecount();
			dump($counts);
			$this -> assign('counts',$counts);
			return $this->fetch();

	}




}