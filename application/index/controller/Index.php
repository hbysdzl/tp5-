<?php

/**
 *   首页控制器
 */

namespace app\index\controller;
use think\Controller;

class Index extends Common
{	

	//首页
    public function index()
    {	
    	$banner = $this->getBanner();
    	$about = $this->getAbout();
  
    	$this->assign([
    		'banner'	=>	$banner,
    		'about'		=>	$about
    	]);

        return $this->fetch();
    }

    //轮播图
   	protected function getBanner() {

   		$result = db('banner')->where('isshow','1')->order('sort desc')->select();

   		return $result;
   	}


   	//关于我们
   	private function getAbout() {

   		$result = db('category')->field('id,name,pic,comment')->where('mark','about')->find();

   		return $result;
   	}

}
