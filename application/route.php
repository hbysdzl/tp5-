<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/*
 * 路由定义
 * */
use think\Route;

//首页
Route::rule('/','index/Index/index','get');

//关于我们
Route::any('page/:id','index/Page/index','get',[],['id'=>'\d+']);

//专业团队
Route::rule('ream/:id','index/Page/team','get',[],['id'=>'\d+']);

//摄影作品
Route::group('works',[
    'list/:id'  =>     ['index/Works/index',['method'=>'get'],['id'=>'\d+']],
    'show/:id'  =>     ['index/Works/showwork',['method'=>'get'],['id'=>'\d+']],
]);

//模特资料
Route::group('model',[

   'list/:id'   =>  ['index/Model/index',['method'=>'get'],['id'=>'\d+']],
    'show/:id'  =>  ['index/Model/showmodel',['method'=>'get'],['id'=>'\d+']],
]);

//摄影场景
Route::group('scene',[
    'list/:id'  =>  ['index/Scene/index',['method'=>'get'],['id'=>'\d+']],
    'show/:id'  =>  ['index/Scene/showscene',['method'=>'get'],['id'=>'\d+']]
]);

//新闻资讯
Route::group('news',[
    'list/:id'  =>  ['index/News/index',['method'=>'get'],['id'=>'\d+']],
    'show/:id'  =>  ['index/News/shownews',['method'=>'get'],['id'=>'\d+']]
]);

//联系我们
Route::get('contactus/:id','index/Contactus/index',[],['id'=>'\d+']);