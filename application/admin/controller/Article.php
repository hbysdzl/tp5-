<?php

/**
 * 内容管理控制器
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Loader;
use app\admin\model\Article as articleModel;
class Article extends Common
{
    /**
     * 显示内容列表
     *
     * @return \think\Response
     */
    public function index($cid = null)
    {   
        config('title','内容列表');
        if ($cid) {
            $map['a.cid'] = $cid;
        }else{
            $map = [];
        }
        //获取数据
        $data = model('Article')->alias('a')->field('a.*,c.name,count(p.pic) picnum')
                ->join('category c','a.cid=c.id')->order('istop desc,toptime desc,addtime desc')
                ->join('pics p','a.id=p.aid','left')->group('a.id')->where($map)
                ->paginate(10,false,['query'=>['cid'=>$cid]]);
        //dump($data);

        //取出栏目数据
        $cateModel = model('Category');
        $datas = $cateModel->field('id,name,pid')->select();
        $cateData = $cateModel->getcates($datas);
        //dump($cateData);
        $this->assign('cateData',$cateData);
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
                //设置顶置
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
            $data = $cateModel->field('id,name,pid,type')->select();
            $cateData = $cateModel->getcates($data);
            $this->assign('cateData',$cateData);
            return $this->fetch();
        }
    }


    //内容编辑
    public function edit(Request $request) {

        if($request->isPost()){
            $data = $request->post();
            if(isset($data['istop'])){
                $data['toptime'] = time();
            }else{
                $data['istop'] = '0';
                $data['toptime'] = '';
            }
            //后端数据合法验证
            $validate = validate('Article');
            if(!$validate->check($data)){
                return json(['code'=>'0','msg'=>$validate->getError()]);
            }
            $res = model('Article')->allowField(true)->isUpdate(true)->save($data);
            if($res){
                return json(['code'=>'1','msg'=>'更新成功！']);
            }

            return json(['code'=>'0','msg'=>'更新失败！']);
        }else{
            config('title','内容编辑');
            //获取栏目数据
            $cateModel = model('Category');
            $datas = $cateModel->field('id,name,pid,type')->select();
            $cateData = $cateModel->getcates($datas);
            $this->assign('cateData',$cateData);

            //取出数据
            $id = $request->param('id');
            $editData = articleModel::alias('t1')->field('t1.*,t2.type')->join('category t2','t1.cid=t2.id')->find($id);
            
            //取出图片数据    
            $res = db('pics')->field('pic')->where('aid',$id)->select();
            $editData['pics'] = $res;
            //dump($editData);
            $this->assign('editData',$editData);
            return $this->fetch();
        }
    }

    /**
     * 内容置顶操作
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function stick(Request $request)
    {
        if ($request->isAjax()) {
            
            $data = $request->post();
            $val['id'] = $data['id'];
            $val['toptime'] = time();
            $articleModel = model('Article');
            if ($data['status'] == 'true') {
                //置顶
                $val['istop'] = '1';
                if($articleModel::update($val)){
                    return json(['code'=>'1','msg'=>'置顶成功！']);
                }
                return json(['code'=>'0','msg'=>'操作失败']);
            }else{

                //取消置顶
                $val['istop'] = '0';
                if ($articleModel::update($val)) {
                    return json(['code'=>'1','msg'=>'取消成功！']);
                }

                return json(['code'=>'0','msg'=>'操作失败！']);
            }
        }
    }

    //内容图片操作
    public function pics($aid) {

        //获取图片数据
        $picData = db('pics')->where('aid',$aid)->order('sort desc')->select();
        $this->assign('picData',$picData);
        return $this->fetch();
    }
    

    //内容图片排序
    public function sortpic() {
        $data['id'] = input('get.id');
        $data['sort'] = input('get.sort');

        $result = db('pics')->update($data);
        if($result){
            return json(['code'=>'1','msg'=>'操作成功！']);
        }

        return json(['code'=>'0','msg'=>'操作失败！']);
    }


    //图片的删除
    public function delpics(){
        $id = input('get.id');
        $picurl = db('pics')->field('pic')->find($id);

        if(db('pics')->delete($id)){
            $picPath = ROOT_PATH.'public/'.$picurl['pic'];
            if(file_exists($picPath)){
                //删除硬盘图片
                @unlink($picPath);
            }

            return json(['code'=>'1','msg'=>'删除成功！']);
        }

        return json(['code'=>'0','msg'=>'删除失败']);
    }
    

    /**
     * 删除内容
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delarticle($id)
    {
        $articleModel = model('Article');
        if($articleModel::destroy($id)){

            return json(['code'=>'1','msg'=>'删除成功！']);
        }

        return json(['code'=>'0','msg'=>'删除失败！']);
    }


    //内容批量删除
    public function delall() {
        $data = input('post.');
        if (!isset($data['id'])) {
            
            $this->error('请选择要删除的记录！');
        }

        if(articleModel::destroy($data['id'])){
            $this->success('删除成功！','index');
        }

        $this->error('删除失败！');
    }


}
