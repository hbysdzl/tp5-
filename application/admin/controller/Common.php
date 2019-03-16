<?php 

/**
 * 后台公共控制器
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
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

		//获取网站配置信息
		$configRes = db('config')->find();
		$config = json_decode($configRes['config'],true);
		
		$this->assign('config',$config);

	}

	//图片上传
    public function upload(Request $request) {

        $file = $request->file('file');

        if($file){
            $info = $file->move(ROOT_PATH.'public/uploads');
            if($info){
                //返回图片路径
                $path = '/uploads/'.$info->getSaveName();
                return json(['code'=>'1','msg'=>'上传成功','filepath'=>$path]);
            }else{

                return json(['code'=>'0','msg'=>$file->getError()]);

            }
        }
    }

	//单张图片删除
	public function delimg($imgurl='') {
		//echo $imgurl;
		if($imgurl !== '' || !empty($imgurl)){

			$filepath = ROOT_PATH.'public'.$imgurl;
			//判断文件是否存在
			if(file_exists($filepath)){
				$res = unlink($filepath);
				if($res){
					$this->delDatabaseImg($imgurl);
					return json(['code'=>'1','msg'=>'删除成功！']);
				}

				return json(['code'=>'0','msg'=>'删除失败！']);	
			}

			//文件不存在
			$this->delDatabaseImg($imgurl);
			return json(['code'=>'2','msg'=>'文件不存在']);

		}
	}

	//删除数据库记录
	protected function delDatabaseImg($pic = '') {

		$res = db('pics')->where('pic',$pic)->find();
		if($res){
			db('pics')->where('pic',$res['pic'])->delete();
		}
	}
}