<?php 

/**
 * 联系我们
 *		
 */


namespace app\index\controller;
use think\Controller;


class Contactus extends Common {


	public function index() {

		return $this->fetch('page/index');
	}
}