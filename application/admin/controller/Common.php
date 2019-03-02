<?php 

/**
 * 后台公共控制器
 */

namespace app\admin\controller;

use think\Controller;

class Common extends Controller {


	//调用控制器初始化方法验证用户登录状态

	protected function _initialize() {
		parent::_initialize();   //调用父类的构造方法

		if(!session('adminName','','admin') || !session('adminId','','admin')) {

			//获取当前访问的控制器&&方法
			$controller = request()->controller();
			$action = request()->action();

			if($controller == 'Index' && $action == 'index') {
				$this->redirect('Login/login');
			}else{
				$this->error('未登录，无法访问！','Login/login');
			}
			exit;
		}


	}
}