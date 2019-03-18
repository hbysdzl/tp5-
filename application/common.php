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