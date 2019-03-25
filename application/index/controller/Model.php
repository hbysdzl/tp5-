<?php 

/**
 * 	模特资料管理控制器
 ** 
 */

namespace app\index\controller;

use think\Controller;


class Model extends Common
{
	
	public function index() {

		return $this->fetch();
	}
}