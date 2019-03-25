<?php 


/**
 *  前台公共控制器
 * 
 */


namespace app\index\controller;
use think\Controller;

/**
* 
*/
class Common extends Controller
{
	
	
	//初始化方法
	public function _initialize() {

		//获取栏目数据

		$catedata = db('category')->field('id,name,pid')->where('pid','0')->order('sort desc,id asc')->select();

		foreach ($catedata as $k => &$v) {
			$cate2 = db('category')->field('id,name,pid')->where('pid',$v['id'])->order('sort desc,id asc')->select();
			$v['child'] = $cate2;
		}
		$this->assign('cate',$catedata);
		
	}

}