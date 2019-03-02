<?php

/*
*** 管理员登录
*/

namespace app\admin\model;

use think\Model;

class Login extends Model
{	

	//定义为管理员表
	protected $table = 'qi_manage';
	
    //登录验证

    public static function checkLogin($data) {

    	//使用场景验证

    	//实例化验证器类
    	$validate = \think\Loader::validate('Manage');

    	if(!$validate->scene('login')->check($data)){

    		return ['code'=>'0','msg'=>$validate->getError()];
    	}

    	$res = self::where('username',$data['username'])->field('id,username,password,face,status')->find();

    	if(!$res || $res['status'] == '-1') {
    		return ['code'=>'0','msg'=>'用户不存在'];
    	}

    	if($res['status'] == '0') {
    		return ['code'=>'0','msg'=>'账号已锁定,无法登录！','mid'=>$res['id']];
    	}

    	if (md5($data['password'])!= $res['password']) {
    		
    		return ['code'=>'0','msg'=>'密码错误！','mid'=>$res['id']];
    	}

    	//保存用户信息到session中
    	session('adminName',$res['username'],'admin');
    	session('adminId',$res['id'],'admin');
        session('adminFace',$res['face']);
    	return ['code'=>'1','msg'=>'登录成功','mid'=>$res['id']];
    }
}
