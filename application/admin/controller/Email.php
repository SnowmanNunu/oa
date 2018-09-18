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
		$data = $email->sendBox();

		$counts = Db::table('sp_email')->alias(['sp_email'=>'t1','sp_user'=>'t2'])->join('sp_user','t1.to_id= t2.id')->count();
		$this -> assign('counts',$counts);
		$this -> assign('data',$data);
		return $this->fetch();
	}


	public function recBox()
	{
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