<?php 

/**
 * 内容管理验证器
 */
namespace app\admin\validate;
use think\Validate;

class Article extends Validate {

	//验证规则
	protected $rule = [
		'cid'		=>		'require',
		'title'		=>		'require|min:2|max:20',
		'keyword'	=>		'require|min:2|max:50',
		'views'		=>		'require|checkViews:1',
		'__token__'	=>		'require|token'
	];

	//错误提示
	protected $message = [
		'cid.require'		=>	'请选择所属栏目',
		'title.require'		=>	'内容标题不得为空',
		'title.min'			=>	'内容标题最少2位字符',
		'title.max'			=>	'内容标题最长为20位字符',
		'keyword.require'	=>	'内容关键词不得为空',
		'keyword.min'		=>	'内容关键词最少2位字符',
		'keyword.max'		=>	'内容关键词不得超过50位字符',
		'views.require'		=>	'浏览次数不得为空',
		'views.checkViews'	=>	'浏览次数至少为1次',
		'__token__.require'	=>	'非法提交',
		'__token__.token'	=>	'请勿重复提交',
	];


	//自定义验证规则
	protected function checkViews($value,$rule) {
		if($value < $rule){
			return false;
		}

		return true;
	}
}