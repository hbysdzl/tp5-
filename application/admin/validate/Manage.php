<?php 

/****
***   管理员操作验证器类
*** 
*/

namespace app\admin\validate;

use think\Validate;


class Manage extends Validate {


	//定义验证规则
	protected $rule = [

		'username'		=>		'require|min:2|max:10|unique:manage',
		'password'		=>		'require|min:6|max:16',
		'passwords'		=>		'require|confirm:password',
		'realityname'	=>		'require|min:2|max:6',
		'email'			=>		'require|email',
		'tel'			=>		'require|min:11|max:11|unique:manage',
		'code'          =>      'require|captcha'
	];

	//错误提示

	protected $message = [
		'username.require'		=>		'用户名不能为空',
		'username.min'			=>		'用户名最少为2个字符',
		'username.max'			=>		'用户名最大为10个字符',
		'username.unique'		=>		'用户名已存在',
		'password.require'		=>		'用户密码不得为空',
		'password.min'			=>		'用户密码最少为6位',
		'password.max'			=>		'用户密码不得超过16位',
		'passwords.require'		=>		'请输入确认密码',
		'passwords.confirm'		=>		'密码输入不一致',
		'realityname.require'   =>		'真实姓名不得为空',
		'realityname.min'		=>		'真实姓名最少为2个字符',
		'realityname.max'		=>		'真实姓名不得超过6个字符',
		'email.require'			=>		'邮箱不能为空',
		'email.email'			=>		'邮箱格式错误',
		'tel.require'			=>		'手机号不得为空',
		'tel.min'				=>		'手机号格式错误',
		'tel.max'				=>		'手机号格式错误',
		'tel.unique'			=>		'该手机号已注册',
		'code.require'		    =>		'请输入验证码',
		'code.captcha'		    =>		'验证码错误',
	];

	//定义场景
	protected $scene = [
		'add'		=>	['username','password','passwords','realityname','email','tel'],
		'editpwd'	=>	['password','passwords'],
		'edit'		=>	['realityname','email','tel'=>'require|min:11|max:11'],
		'login'		=>	['username'=>'require|min:2|max:10','password','code'],
	];
}