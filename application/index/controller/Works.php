<?php 


/**
 * 
 *	摄影作品管理
 */

namespace app\index\controller;
use think\Controller;

class Works extends Common {

    /*
     * 初始化方法
     *
     * */
    public function _initialize() {
        //调用父类的构造方法
        parent::_initialize();

        //获取左侧二级导航栏目信息
        $zuopin = $this->getChildcate('zuopin');
        $this->assign('zuopin',$zuopin);
        //dump($zuopin);
    }



	//摄影作品
	public function index($id) {

         //获取栏目名称
        $catename = db('category')->field('name')->find($id);
	    //获取摄影作品数据
	    $data = db('article')->alias('t1')->field('t1.title,t1.id,t2.pic')->join('pics t2','t1.id=t2.aid','left')->where('t1.cid',$id)->paginate(2);
	    if(!count($data)){
	        //手动抛出异常
            abort('404');
        }
	    $this->assign('catename',$catename['name']);
	    $this->assign('data',$data);
		return $this->fetch();
	}

	/*
	 * 摄影作品详情页
	 * */

	public function showwork($id){

	    //获取详情数据
        $descdata = db('article')->field('id,cid,title,keyword,desc,author,views,content,addtime')->find($id);

        $this->assign('descdata',$descdata);

	    return $this->fetch();
    }

}