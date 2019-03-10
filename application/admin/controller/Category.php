<?php

/**
 * ；栏目管理
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Category as CategoryModel;

class Category extends Common
{
    /**
     * 显示栏目列表
     *
     * @return \think\Response
     */
    public function index()
    {
        if(request()->isPost()){
            $data = input('post.');
            $res = CategoryModel::sort($data);
            if ($res) {
                
                $this->success('排序成功！','index');
            }
        }else{
            //获取数据
            $data = CategoryModel::getcates(CategoryModel::order('sort desc')->select());
            $this->assign('data',$data);
            return $this->fetch(); 
        }
       
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

            $data = $request->post();
            $data['addtime'] = time(); 
            $res = CategoryModel::insert($data);
            if(!$res){
                return json(['code'=>'0','msg'=>'添加失败！']);
                exit;
            }

            return json(['code'=>'1','msg'=>'添加成功！']);
        }else{

            //取出上级栏目
            $data = CategoryModel::select();
            $data = CategoryModel::getcates($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

   
    /**
     * 栏目编辑
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function edit(Request $request)
    {
        if($request->isPost()){
            $data = $request->post();
            //需判断禁止更新上级栏目为自身和其下级子栏目
             $arrid = CategoryModel::getchildId($data['id']);
             $arrid[] = $data['id'];
             //dump($arrid);
             if (in_array($data['pid'], $arrid)) {
                return json(['code'=>'0','msg'=>'上级栏目选择错误！']);
                exit;
             }
            
            $res = CategoryModel::update($data);
            if (!$res) {
                
                return json(['code'=>'0','msg'=>'更新失败！']);
            }

            return json(['code'=>'1','msg'=>'更新成功！']);
        }else{
            //取出上级栏目
            $data = CategoryModel::getcates(CategoryModel::all());
            $id = $request->param('id');
            //取出编辑数据
            $editData = CategoryModel::find($id);
            if($editData->pic !== ''){
              //处理图片字符串为数组
              $editData->imgarr = explode(',', $editData->pic);  
            }
            
            //dump($editData);
            $this->assign('editData',$editData);
            $this->assign('data',$data);
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

        //如果其有栏目则不可删除
        $chlid = CategoryModel::where('pid',$id)->select();
        if(count($chlid) > 0){
            return json(['code'=>'0','msg'=>'错误！请先删除其子栏目']);
        }
        $img = CategoryModel::field('pic')->find($id);
        $res = CategoryModel::destroy($id);

        if(!$res){
            return json(['code'=>'0','msg'=>'删除失败！']);
        }

        //将硬盘的图片删除
        $img = explode(',', $img['pic']);
        foreach ($img as $k => $v) {
            $this->delimg($v);
        }
        return json(['code'=>'1','msg'=>'删除成功！']);


    }

    /*
     **** 栏目图片上传
    */

    public function cateUpload(Request $request) {

        $file = $request->file('file');

        if($file){
            $info = $file->move(ROOT_PATH.'public/uploads/category');
            if($info){
                //返回图片路径
                $path = '/uploads/category/'.$info->getSaveName();
                return json(['code'=>'1','msg'=>'上传成功','filepath'=>$path]);
            }else{

                return json(['code'=>'0','msg'=>$file->getError()]);

            }
        }
    }
}
