<?php

/**
 * 内容管理控制器
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Loader;
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
        //获取数据
        $data = model('Article')->alias('a')->field('a.*,c.name')->join('category c','a.cid=c.id')->paginate(3);
        $this->assign('data',$data);
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

            //后端数据验证
            $validate = Loader::validate('Article');
            if(!$validate->check($data)){
                return json(['code'=>'0','msg'=>$validate->getError()]);
            }
            $data['addtime'] = time();
            if(isset($data['istop'])){
                //设置定置
                $data['toptime'] = time();
            }

            //过滤非数据表字段
            $res = model('Article')->allowField(true)->save($data);
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
