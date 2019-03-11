<?php

/**
 * 内容管理控制器
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Article extends Common
{
    /**
     * 显示内容列表
     *
     * @return \think\Response
     */
    public function index()
    {   
        config('title','内容列表');
        return $this->fetch();
    }


    /**
     * 添加内容
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {   
        if ($request->isPost()) {
            $data = $request->post();
            $data['addtime'] = time();
            if(isset($data['istop'])){
                //设置定置
                $data['toptime'] = time();
            }

            $res = model('Article')->save($data);
            if($res){
                return json(['code'=>'1','msg'=>'添加成功！']);
            }

            return json(['code'=>'0','msg'=>'添加失败！']);
        }else{

            //取出栏目数据
            $cateModel = model('Category');
            $data = $cateModel->field('id,name,pid')->select();
            $cateData = $cateModel->getcates($data);
            //dump($cateData);
            $this->assign('cateData',$cateData);
            return $this->fetch();
        }
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
