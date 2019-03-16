<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Banner extends Common
{
    /**
     * 轮播图列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //取出数据
        $data = model('Banner')->order('sort desc')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

   

    /**
     * 添加
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $data['addtime'] = time();
            if(!isset($data['isshow'])){
                $data['isshow'] = '0';
            }
            $res = model('Banner')->allowField(true)->isUpdate(false)->save($data);
            if ($res) {
                return json(['code'=>'1','msg'=>'新增成功！']);
            }

            return json(['code'=>'0','msg'=>'新增失败！']);
        }else{

            return $this->fetch();
        }
    }

   
    /**
     * 轮播图编辑
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        if ($request->isPost()) {
            
            $data = $request->post();
            if (!isset($data['isshow'])) {
                $data['isshow'] = '0';
            }

            $res = model('Banner')->allowField(true)->isUpdate(true)->save($data);
            if ($res === false) {    
                return json(['code'=>'0','msg'=>'更新失败！']);
            }
            return json(['code'=>'1','msg'=>'更新成功！']);
        }else{
            
            //获取编辑的数据
            $id = $request->param('id');
            $editData = model('Banner')->find($id);
            $this->assign('editData',$editData);
            return $this->fetch();
            
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $res = model('Banner')->find($id);
        if (model('Banner')->destroy($id)) {
            
            //删除图片
            $this->delimg($res['pic']);
            return json(['code'=>'1','msg'=>'删除成功！']);
        }

        return json(['code'=>'0','msg'=>'删除失败！']);
        //dump($res);
    }


    //异步处理数据
    public function setajax() {
        if (request()->isAjax()) {
            
            $data = request()->get();
            //dump($data);

            $newData = [];
            $newData['id'] = $data['id'];
            switch ($data['type']) {
                case 'show':
                    $newData['isshow'] = $data['v'];
                    break;  
                case 'sort':
                    $newData['sort'] = $data['v'];
                    break;
            }

            if(model('Banner')->update($newData)){
                return json(['code'=>'1','msg'=>'操作成功！']);
            }

            return json(['code'=>'0','msg'=>'操作失败！']);
        }
    }
}
