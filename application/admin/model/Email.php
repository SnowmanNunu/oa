<?php
namespace app\admin\model;
use think\Model;
// use think\Db;

class Email extends Model
{
	// 文件上传提交
	public function up(Request $request)
	{
	// 获取表单上传文件
	$file = $request->file('file');
	if (empty($file)) {
	$this->error('请选择上传文件');
	}
	// 移动到框架应用根目录/public/uploads/ 目录下
	$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
	if ($info) {
	$this->success('文件上传成功：' . $info->getRealPath());
	} else {
	// 上传失败获取错误信息
	$this->error($file->getError());
	}
	}

}