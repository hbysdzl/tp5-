<?php

/*
*** 管理员管理
*/

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Manage as ManageModel;

class Manage extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        config('title','管理员列表');
        

        //分页获取数据
        $data = ManageModel::where('status','>','-1')->order('addtime desc')->paginate(2);
        $this->assign('data',$data);   
        return $this->fetch();
    }

    

    /**
     * 添加管理员
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function add(Request $request)
    {   
        if ($request->isPost()) {
           $data = $request->post();
           
           //后端数据验证
           $validate = \think\Loader::validate('Manage');
           if(!$validate->scene('add')->check($data)){
                return json(array('status'=>'0','msgs'=>$validate->getError()));
                exit;
           }

           //新增入库
           $model = model('Manage');
           $result = $model->addManage($data);
           if($result['code'] == '1'){
              return json(array('status'=>'1','msgs'=>$result['msg']));
           }else{
              return json(array('status'=>'0','msgs'=>$result['msg']));
           }
        }else{
            config('title','添加管理员');
            return $this->fetch();
        }
        
    }

    //头像上传
    public function uploadFace() {

        $file = request()->file('file');
        if($file) {

            //移动文件实现上传
            $info = $file->move(ROOT_PATH.'public/static/admin/uploads/face');
            if($info) {
                return json('/static/admin/uploads/face/'.$info->getSaveName());
            }else{

                //获取错误信息
                return json($file->getError());
            }   
        }
    }

    

   

    /**
     * 修改管理员
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request,$id)
    {
        if($request->isPost()){
            $data = $request->post();

            $model = model('Manage');

            $result = $model->editManage($data,$id);

            if($result['code'] == '1') {
                return json(array('code'=>'1','msgs'=>$result['msg']));
            }else{
                return json(array('code'=>'0','msgs'=>$result['msg']));
            }

        }else{

            config('title','修改管理员');
            //获取修改的数据
            $editData = ManageModel::get($id);
            $this->assign('editData',$editData);
            return $this->fetch();
        }
    }


    /**
     * 修改密码
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function editpwd()
    {   
        if (request()->isPost()) {
            $data = input('post.');

            //数据合法性验证
            $validate = validate('Manage');
            if (!$validate->scene('editpwd')->check($data)) {
                return json(array('code'=>'0','msgs'=>$validate->getError()));
            }

            //验证旧密码
            $res = ManageModel::field('password')->find(session('adminId','','admin'));
            if(md5($data['oldpassword']) != $res['password']){
                return json(array('code'=>'0','msgs'=>'旧密码错误!'));
            }

            //修改为新密码
            $result = ManageModel::where('id',session('adminId','','admin'))->setField('password',md5($data['password']));
            if ($result) {
                return json(array('code'=>'1','msgs'=>'修改成功！'));
            }else{
                return json(array('code'=>'0','msgs'=>'系统忙，请稍后重试！'));
            }
        }else{
            config('title','修改密码');
            return $this->fetch();
        }
    }

    /**
     * 删除管理员
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        if($id == '1'){
            return json(array('code'=>'0','msg'=>'超级管理员不可删除！'));
        }

        $result = ManageModel::where('id',$id)->setField('status','-1');

        if ($result) {
            return json(array('code'=>'1','msg'=>'删除成功！'));
        }else{
            return json(array('code'=>'0','msg'=>'删除失败！'));
        }
    }
}
