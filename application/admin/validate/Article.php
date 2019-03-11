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
		'title'		=>		'require|min:2|max:20'
	]
}