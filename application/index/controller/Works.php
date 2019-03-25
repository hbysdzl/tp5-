<?php 


/**
 * 
 *	摄影作品管理
 */

namespace app\index\controller;
use think\Controller;

class Works extends Common {


	//摄影作品
	public function index() {


		return $this->fetch();
	}
}