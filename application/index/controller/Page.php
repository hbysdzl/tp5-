<?php

/**
 *   单页栏目
 */

namespace app\index\controller;

use think\Controller;
use think\Request;

class Page extends Common
{


    /**
    *****  初始化方法获取左侧栏目
     ****
     **/
    public function _initialize(){
        parent::_initialize();

        $about = $this->getChildCate('about');
        $zuopin = $this->getChildCate('zuopin');
        $this->assign([
            'about'     =>      $about,
            'zuopin'    =>      $zuopin
        ]);
    }
    /**
     * 
     *  单页栏目
     *
     * @return \think\Response
     */
    public function index($id)
    {

        $res = db('category')->field('id,mark,name,comment')->find($id);

        $this->assign('pagedata',$res);
        return $this->fetch();
    }

    /**
     * 专业团队
     *
     * @return \think\Response
     */
    public function team($id)
    {

        //获取数据
        $res = db('article')->alias('t1')->field('t1.title,t1.id,t1.zhiwu,t1.team,t2.pic')->join('pics t2','t1.id=t2.aid','left')->where('cid',$id)->paginate(2);

        $this->assign('res',$res);
        return $this->fetch();
    }

    /**
     * 专业团队详情页
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function teamShow(Request $request)
    {
        //查出详情数据
        $id = $request->param('id');

        $descdata = db('article')->field('id,cid,title,keyword,desc,views,content,addtime')->find($id);

        $this->assign('descdata',$descdata);
        return $this->fetch();
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
