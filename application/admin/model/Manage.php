<?php

/*
**** 管理员操作
**** 
*/

namespace app\admin\model;

use think\Model;

class Manage extends Model
{
    
    //新增管理员
    public function addManage($data) {

    	unset($data['passwords']);
    	$data['password'] = md5($data['password']);
    	$data['addtime'] = time();
    	if($this->save($data)){
    		$msg['code'] = '1';
    		$msg['msg']	= '新增成功';
    	}else{
    		
    		$msg['code'] = '0';
    		$msg['msg'] = $this->getError();
    	}

    	return $msg;
    }


    //编辑管理员
    public function editManage($data,$id) {

    	//验证账号不可修改
    	if(isset($data['username'])){
    		return array('code'=>'0','msg'=>'管理员账号不可修改！');
    	}

    	//实例化验证器类进行验证
    	$validate = validate('Manage');
    	if($data['password'] == ''){
    		unset($data['password']);
    		unset($data['passwords']);
    	}else{
    		if(!$validate->scene('editpwd')->check($data)){
    			return array('code'=>'0','msg'=>$validate->getError());
    		}
    		$data['password'] = md5($data['password']);
    		unset($data['passwords']);
    	}

    	if(!$validate->scene('edit')->check($data)) {
    		return array('code'=>'0','msg'=>$validate->getError());
    	}
    	

    	//超级管理员不允许锁定
    	if($id == '1' && $data['status'] == '0') {
    		return array('code'=>'0','msg'=>'超级管理员不允许锁定！');
    	}

    	//是否修改图像
    	if($data['face'] == '') {
    		unset($data['face']);
    	}else {
    		//将旧的图片从硬盘上删除
    		if($data['oldface']){
    			unlink('.'.$data['oldface']);
    		}
    	}
    	unset($data['oldface']);

    	//更新入库
    	$result = $this->where('id',$id)->update($data);
    	if($result === false){
    		return array('code'=>'0','msg'=>$this->getError());
    	}

    	return array('code'=>'1','msg'=>'修改成功！');

    }

}
