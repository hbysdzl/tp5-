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
		$catedata = db('category')->field('id,name,pid,type')->where('pid','0')->where('isshow','1')->order('sort desc,id asc')->select();

		foreach ($catedata as $k => &$v) {
			$cate2 = db('category')->field('id,name,pid,type')->where('pid',$v['id'])->where('isshow','1')->order('sort desc,id asc')->select();
			$v['child'] = $cate2;
		}

		//获取当前的一级栏目
		$controller = request()->controller();
		$currtype = $this->getCurr($controller);

		//网站配置信息
		$config = db('config')->field('config')->find();
		$config = json_decode($config['config'],true);
		//dump($config);
		//关站提示
		if (!isset($config['state'])) {
			exit($config['closeinfo']);
		}

		$this->assign([
			'cate'		=>	$catedata,
			'currtype'	=>	$currtype,
			'config'	=>	$config
        ]);
		
	}

	//获取顶级栏目类型
	protected function getCurr($controller) {
		switch ($controller) {
            case 'Index':
				return '0';
				break;
			
			case 'Page':
				return '1';
				break;

			case 'Works':
				return '2';
				break;

			case 'Model':
				return '3';
				break;

			case 'Scene':
				return '4';
				break;

			case 'News':
				return '5';
				break;

            case 'Contactus':
				return '6';
				break;
			default:
				
				return '0';
				break;
		}
	}

}