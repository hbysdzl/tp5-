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
        $work = $this->getWorks();

        $huoban = $this->getHuoban();
    	$this->assign([
    		'banner'	=>	$banner,
    		'about'		=>	$about,
            'works'     =>  $work,
            'huoban'    =>  $huoban
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


   	// 获取摄影作品数据
    private function getWorks() {

        $res = db('category')->field('id')->where('mark','works')->find();

        //获取摄影作品下的子栏目
        $res = db('category')->field('id,name,type,sort')->where('pid',$res['id'])->select();

        //获取摄影栏目下的内容
        foreach ($res as $k => &$v) {
            $article = db('article')
            ->alias('t1')
            ->field('t1.id,t1.title,t2.pic')
            ->join('pics t2','t1.id=t2.aid','left')
            ->where('t1.cid',$v['id'])
            ->where('t1.istop','1')
            ->select();
            $v['article'] = $article;
        }
        return $res;
    }

    //合作伙伴
    private function getHuoban() {
        // 查出该栏目
        $lan = db('category')->field('id')->where('mark','huoban')->find();

        //查出对应内容
        $res = db('article')->alias('t1')->join('pics t2','t1.id=t2.aid','left')
            ->field('t1.id,t1.title,t2.pic')
            ->where('t1.cid',$lan['id'])->where('t1.istop','1')
            ->order('toptime desc,addtime desc')
            ->select();


        return $res;
    }




}
