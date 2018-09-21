<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class Email extends Model
{
    
    //上传函数upload
	public function upload(){
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('file');
    
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

        if($info){
            // 成功上传后 获取上传信息
            $data['file'] = $info->getSaveName();
            //$data['file'] = "public/uploads/".$info->getSaveName();
            $data['filename'] = $info->getFilename();
        	return $data;
            // 输出 jpg
            //echo $info->getExtension();

            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getSaveName();

            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
}



    public function recUser(){
        $data = db('user')->field('id,truename')->where('id !=' . session('id')) ->select();
        return $data;
    }

    public function sendBox(){
        $data = Db::table('sp_email')-> field('t1.*,t2.truename as truename')->alias(['sp_email'=>'t1','sp_user'=>'t2'])-> where('t1.from_id = ' . session('id'))->Join('sp_user','t1.to_id= t2.id')->paginate(2);
        $counts = Db::table('sp_email')->alias(['sp_email'=>'t1','sp_user'=>'t2'])->join('sp_user','t1.to_id= t2.id')->count();
       // $data['data']=$data;
       // $data['counts']=$counts;
       return $data;
    }

    public function recBox(){
        $data = Db::table('sp_email')-> field('t1.*,t2.truename as truename')->alias(['sp_email'=>'t1','sp_user'=>'t2'])-> where('t1.to_id ='.session('id'))->join('sp_user','t1.from_id= t2.id')->paginate(2);
        return $data;
    }


}