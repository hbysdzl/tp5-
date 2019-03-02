<?php
//配置文件
return [
	// 视图输出字符串内容替换
    'view_replace_str'       => [

    	'__ADMIN__'		=>	'/static/admin',
    ],


    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'   =>  [
        // SESSION 前缀
        'prefix'         => 'admin',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

];