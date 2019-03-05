<?php

/**
 * ；栏目管理
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Category extends Controller
{
    /**
     * 显示栏目列表
     *
     * @return \think\Response
     */
    public function index()
    {
        
        return $this->fetch();
    }

    

    /**
     * 添加栏目
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {
        if($request->isPost()){

        }else{
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
