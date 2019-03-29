<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//显示文件大小
function fileFont($size=0,$num=0){

	$unit = ['B','KB','MB','GB','TB'];
	$i = 0;
	while ($size > 1024) {
		$size/=1024;
		$i++;
	}

	return round($size,$num).$unit[$i];
}


//生成栏目链接地址

function makeurl($type=1,$id){
	$url = '';
	switch($type){
		case '1':
		$url = url('index/Page/index',['id'=>$id]);
		break;

		case '2':
		$url = url('index/Works/index',['id'=>$id]);
		break;

		case '3':
		$url = url('index/Model/index',['id'=>$id]);
		break;

		case '4':
		$url = url('index/Scene/index',['id'=>$id]);
		break;

		case '5':
		$url = url('index/News/index',['id'=>$id]);
		break;

		case '6':
		$url = url('index/Page/team',['id'=>$id]);
		break;

		case '7':
		$url = url('index/Contactus/index',['id'=>$id]);
		break;

		default:
		$url = url('index/Index/index');

	}

	//判断当前栏目下是否有二级栏目
	$res = db('category')->where('pid',$id)->select();
	if($res){
		$url = 'javascript:void(0)';
	}

	return $url;
}


/*
 * 当前位置，面包屑
 *
 * @param  int当前所在的栏目id
 * @return string当前位置
 * */

function getPosition($cid){

    //查出当前的栏目信息
    $cat = db('category')->field('id,name,pid')->find($cid);
    $str = '';

    if($cat){
        $str = '> <a href="javascript:void(0)">'.$cat['name'].'</a>';
        if ($cat['pid'] != 0){

            //非顶级栏目
            $parent = getPosition($cat['pid']);
            $str = $parent.$str;
        }
        return $str;
    }
}