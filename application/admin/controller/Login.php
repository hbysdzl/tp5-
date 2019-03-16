<?php

/*
/***  管理员登录
****
*/

namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\Login as loginModel;

class Login extends Controller
{
    /**
     * 管理员登录
     *
     * @return \think\Response
     */
    public function login()
    {   
        if (request()->isPost()) {
            $data = input('post.');
            $result = loginModel::checkLogin($data);
            if(isset($result['mid'])) {
                //记录管理员登录日志
                $log_data = [
                    'mid'       =>    $result['mid'],
                    'ip'        =>    request()->ip(),
                    'logintime' =>    time(),
                    'msg'       =>    $result['msg']
                ];

                //只保留最新15条记录
                $logRows = db('loginlog')->where('mid',$result['mid'])->count();
                if($logRows == 15) {
                    //查出当前用户最早的一条记录
                    $rows_min = db('loginlog')->where('mid',$result['mid'])->min('logintime');
                    //将最旧的记录删除
                    db('loginlog')->where('mid',$result['mid'])->where('logintime',$rows_min)->delete();
                }
                db('loginlog')->insert($log_data);
            }
            return json($result);
        }else{


            //判断登录状态，避免重复登录
            if(session('adminName','','admin') || session('adminId','','admin')) {
                $this->redirect('Index/index');
            }
            config('title','欢迎登录我公司管理系统');
            return $this->fetch();
        }
        
    }

    /**
     * 退出登录
     *
     * @return \think\Response
     */
    public function logout()
    {
        session(null,'admin');
        $this->redirect('Login/login');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
