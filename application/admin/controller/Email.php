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
            'from_id'=>session('id'),
            'to_id'=>$data['to_id'],
            'title'=>$data['title'],
            'file'=>$email->upload(),
            'content'=>$data['content'],
            'addtime'=>time()
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

	 //download
    public function download(){
        //接收id
        $id = input('id');
        //查询信息
        $data = db('email') -> find($id);
        $file_name = $data['filename'];    //下載文件名
        $file_dir = ROOT_PATH.'public'.DS.'uploads'.'/';  //下載文件存放目錄
        //echo $file_dir.$file_name;      //D:\XAMPP\htdocs\oa\public\uploads/
        echo $file_dir;
        // $file_dir = "D:/XAMPP/htdocs/oa/public/uploads/20180919/";
        // $file_name = "9205672a411be2bd619e77a332e59f84.jpg";

       // echo $file_dir.$file_name;
        if (!file_exists($file_dir.$file_name)) {
            echo "文件找不到！";
            exit();
        }else{
            $file1 = fopen($file_dir.$file_name,'r');
            header("Content-type: application/octet-stream");
            header("Accept-Ranges:bytes");
            header("Accept-Length:".filesize($file_dir.$file_name));
            header("Content-Disposition:attachment;filename=".$file_name);
            ob_clean();
            flush();      //清除文件中多餘的路徑名以及解決亂碼的問題
           // echo fread($file1, filesize($file_dir.$file_name));
            fclose($file1);
            exit();
        }
    }








}