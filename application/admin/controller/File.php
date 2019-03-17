<?php

/**
 *   文件管理
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class File extends Controller
{
    /**
     * 文件列表
     *
     * @return \think\Response
     */
    public function index()
    {   
        //获取当前工作目录（站点根目录）
        $rootdir = getcwd();
        //打开当前目录返回目录句柄资源
        $dir = opendir($rootdir);
        //读取目录文件
        $data = [];
        while ($filename = readdir($dir)) {
            if ($filename !='.' && $filename != '..') {

                //根据文件和目录区分图标
                if (is_dir($filename)) {
                    $arr['icon'] = '&#xe622;';
                }else{
                    $arr['icon'] = '&#xe621;';
                }
                
                $arr['filename'] = $filename;
                $arr['size'] = filesize($filename); //文件大小 返回文件字节数
                $arr['ctime'] = filectime($filename); //文件创建时间
                $arr['mtime'] = filemtime($filename); //文件修改时间
                $data[] = $arr;
            }
            
        }
        $this->assign([
                'curdir'    =>  $rootdir,
                'filename'  =>  $data   
            ]);
        return $this->fetch('file');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
