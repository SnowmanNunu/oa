<?php
namespace app\admin\controller;
use think\Controller;

/**
 * 
 */
class Dept extends Controller
{

	public function showlist()
	{
		return $this->fetch();
	}

	public function add()
	{
		return $this->fetch();
	}

	public function edit()
	{
		return $this->fetch();
	}
}