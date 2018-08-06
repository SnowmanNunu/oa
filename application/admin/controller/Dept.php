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
}