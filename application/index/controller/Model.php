<?php 

/**
 * 	模特资料管理控制器
 ** 
 */

namespace app\index\controller;

use think\Controller;


class Model extends Common
{

    /*
     * 构造方法获取左侧栏目
     * */
    public function _initialize(){
        parent::_initialize();

        $leftMenu = $this->getChildCate('model');
        $this->assign('leftMenu',$leftMenu);
    }


	public function index($id) {

	    //获取模特列表数据
        $modelLst = db('article')->alias('t1')->join('pics t2','t1.id=t2.aid','left')
            ->field('t1.id,t1.title,t1.model,t2.pic')
            ->where('t1.cid',$id)
            ->order('istop desc,toptime desc addtime desc')
            ->paginate(2);
        //当前栏目名称
        $catename = db('category')->field('name')->find($id);
        $this->assign('catename',$catename);
        $this->assign('list',$modelLst);
		return $this->fetch();
	}


	/*
	 * 模特详情页
	 * */
	public function showmodel($id) {

	    $descmodel = db('article')->find($id);
	    $this->assign('descmodel',$descmodel);

	    return $this->fetch();
    }
}