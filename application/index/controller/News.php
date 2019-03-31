<?php


/**
 *	新闻资讯
 */

namespace app\index\controller;
use phpDocumentor\Reflection\Types\Parent_;
use think\Controller;


class News extends Common {

    /*
     *  构造方法获取左侧栏目数据
     * */
    public function _initialize(){
        parent::_initialize();

        $leftnews = $this->getChildCate('news');
        $zuopin = $this->getChildCate('zuopin');

        $this->assign([
            'leftnews' =>   $leftnews,
            'zuopin'   =>   $zuopin
        ]);
    }

	public function index($id) {

	    //获取新闻资讯数据列表
        $list = db('article')->alias('t1')->join('pics t2','t1.id=t2.id','left')
            ->field('t1.id,t1.title,t1.author,t1.remark,t1.addtime,t1.views,t2.pic')
            ->order('istop desc,toptime desc,addtime desc')
            ->where('t1.cid',$id)->select();

        //dump($list);
        $this->assign('newslist',$list);
		return $this->fetch();
	}

	/*
	 *  新闻详情页
	 * */
	public function shownews($id){

	    $data = db('article')->find($id);

	    //使用redis记录浏览次数
        if ($data){


            $ip = request()->ip();
            $redis = new \Redis();
            $redis->connect('127.0.0.1',6379);
            //从redis中获取
            $res = $redis->lrange($id,0,-1);
            dump($res);
//            die();
            if (!$res || !in_array($ip,$res)){
                db('article')->where('id',$id)->setInc('views');
                //将用户的ip,文章id,浏览时间写入redis中
                //$redis->hmset($id,array('ip'=>$ip,'viewtime'=>time()));
                //使用链表
                $redis->lpush($id,$ip);
                $redis->setTimeout($id,86400);
            }
        }
        $this->assign('data',$data);
	    return $this->fetch();
    }


}