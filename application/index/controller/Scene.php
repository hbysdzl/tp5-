<?php 

/**
 *   摄影场景
 */

namespace app\index\controller;
use think\Controller;

class Scene extends Common {

    /*
     * 构造方法获取左侧栏目
     * */
    public function _initialize(){

        parent::_initialize();

        $leftMenu = db('category')->where('mark','scene')->select();
        $this->assign('leftMenu',$leftMenu);
    }

	public function index($id) {

        //获取摄影场景列表
        $list = db('article')->alias('t1')->join('pics t2','t1.id=t2.aid','left')
            ->field('t1.id,t1.title,t2.pic')
            ->order('istop desc,toptime desc,addtime desc')
            ->where('t1.cid',$id)->paginate(2);

        $this->assign('list',$list);
		return $this->fetch();
	}


	//场景摄影详情
    public function showscene($id){

        //获取数据
        $descdata = db('article')->find($id);

        $this->assign('descdata',$descdata);
        return $this->fetch();


    }
}