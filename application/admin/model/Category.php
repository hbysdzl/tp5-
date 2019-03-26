<?php

/*
****  栏目管理模型
*/

namespace app\admin\model;

use think\Model;

class Category extends Model
{
    
    //栏目类型获取器
    public function getTypeAttr($value) {

        $type = [
            '1' =>  '单页',
            '2' =>  '摄影作品',
            '3' =>  '模特资料',
            '4' =>  '摄影场景',
            '5' =>  '新闻资讯',
            '6' =>  '专业团队',
            '7' =>  '联系我们',
        ];
        return $type[$value];
    }

    //栏目无限极分类类表
    public static function getcates($data,$pid='0',$level='-1'){

    	static $arr = [];
    	$level+=1;
    	if($level == '0'){
    		$str = '';
    	}else{
    		$str = '|';
    	}
    	foreach ($data as $k => &$v) {
    		if($v['pid'] == $pid){
    			$v['name'] = $str.str_repeat('-----', $level).$v['name'];
    			$arr[] = $v;

    			self::getcates($data,$v['id'],$level);

    			//将已保存过的栏目销毁，避免下次循环
    			unset($v);
    		}
    	}


    	return $arr;
    }


    //获取当前编辑的栏目其子栏目id
    public static function getchildId($id) {
    	$childid = self::field('id')->where('pid',$id)->select();
    	static $arr = [];
    	foreach ($childid as $k => $v) {
    		$arr[] = $v['id'];

    		self::getchildId($v['id']);
    	}

    	return $arr;

    } 


    //栏目排序
    public static function sort($data) {

    	foreach ($data as $k => $v) {
    		self::where('id',$k)->setField('sort',$v);
    	}

    	return true;

    }
}
