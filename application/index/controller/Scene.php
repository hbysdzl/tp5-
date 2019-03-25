<?php 

/**
 *   摄影场景
 */

namespace app\index\controller;
use think\Controller;

class Scene extends Common {

	public function index() {


		return $this->fetch();
	}
}