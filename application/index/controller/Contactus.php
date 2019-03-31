<?php 

/**
 * 联系我们
 *		
 */


namespace app\index\controller;
use think\Controller;


class Contactus extends Common {

    /*
     * 重写构造方法 获取左侧栏目
     * */
    public function _initialize(){
        parent::_initialize();
        $about = $this->getChildCate('about');
        $zuopin = $this->getChildCate('zuopin');

        $this->assign([
            'about'     =>  $about,
            'zuopin'    =>  $zuopin
        ]);
    }

	public function index($id) {

	    //查出数据
        $pageData = db('category')->find($id);

        $this->assign('pagedata',$pageData);

		return $this->fetch('page/index');
	}
}