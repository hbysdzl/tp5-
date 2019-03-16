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

            //修改之后
            self::afterUpdate(function($data){
                //处理新增的图片
                if($data['pic']){
                    $pics = explode(',', $data['pic']);
                    foreach ($pics as $k => $v) {
                        db('pics')->insert([
                                'aid' => $data['id'],
                                'pic' => $v  
                            ]);
                    }
                }
            });

            //删除之后
            self::afterDelete(function($data){
                //删除内容图片表中的数据
                $pics = db('pics')->where('aid',$data['id'])->select();
                if($pics){
                    foreach ($pics as $k => $v) {
                        $imgpath = ROOT_PATH.'public/'.$v['pic'];
                        @unlink($imgpath);
                    }

                    //数据库记录删除
                    db('pics')->where('aid',$data['id'])->delete();
                }

            });
    }



}
