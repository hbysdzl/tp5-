<?php

/**
 *  网站配置管理控制器
 */
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Config extends Common
{
    /**
     * 
     *  配置项列表
     * @return \think\Response
     */
    public function index()
    {
        return $this->fetch();
    }

    

    /**
     * 保存配置
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->post();
        //dump($data);

        //判断库中是否存在记录无则添加有则修改
        $res = db('config')->find();
        //将配置信息转换为json字符串
        $config['config'] = json_encode($data,JSON_UNESCAPED_UNICODE);

        if(!$res){
            $result = db('config')->insert($config);
        }else{
            $result = db('config')->where('id',$res['id'])->update($config);
        }

        if($result){
            return json(array('code'=>'1','msgs'=>'设置成功！'));
        }else{
            return json(array('code'=>'0','msgs'=>'设置失败，请稍后重试！'));
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
