<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Index extends Common
{
    public function index()
    {	
    	config('title','欢迎使用本站管理系统');
        return $this->fetch();
    }

    public function main() {

    	//获取服务器相关信息
    	$serverInfo = [
    		'server_ip'     => 	$_SERVER['SERVER_ADDR'],
    		'server_host'	=>	$_SERVER['SERVER_NAME'],
    		'server_os'		=>	PHP_OS,
    		'server'		=>	$_SERVER['SERVER_SOFTWARE'],
    		'port'			=>	$_SERVER['SERVER_PORT'],
    		'php_ver'		=>	PHP_VERSION,  //php版本
    		'mysql_ver'		=>	Db::query('select version() as ver')[0]['ver'], //mysql版本
    		'database'		=>	config('database.database'),
    		'uploads'		=>	ini_get('upload_max_filesize'),  //上传最大限制
    		'execution'		=>	ini_get('max_execution_time')//脚本最大执行时间
    	];


        //获取当前用户登录日志
        $userlog = Db::name('loginlog')->alias('l')->field('l.*,m.username')->join('manage m','l.mid=m.id','left')->where('mid',session('adminId','','admin'))->order('l.logintime desc')->select();
        
        $this->assign('userlog',$userlog);
    	$this->assign('serverInfo',$serverInfo);
    	return $this->fetch();
    }
}
