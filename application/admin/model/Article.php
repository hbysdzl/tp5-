<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    //注册模型事件
    protected static function init(){

    		//新增之后
    		self::afterInsert(function($data){

    			//处理内容图片
                if ($data['pic']) {
                    $pics = explode(',', $data['pic']);
                    $aid = model('Article')->id;
                    foreach ($pics as $k => $v) {
                        # code...
                        db('pics')->insert([
                            'aid'   =>  $aid,
                            'pic'   =>  $v
                        ]);
                    }
                }
    		});
    }



}
