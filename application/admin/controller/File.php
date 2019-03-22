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
    public function index($currdir = null)
    {   
        //切换目录(绝对路径)
        if($currdir){
            //判断目录是否存在
            if (is_dir($currdir)) {
                //访问权限控制
                if (stripos($currdir, ROOT_PATH) === 0 && stripos($currdir, ROOT_PATH.'..') === false) {

                    chdir($currdir);
                }
                
            }
            
        }
        //获取当前工作目录
        $rootdir = getcwd();
        //打开当前目录返回目录句柄资源
        $dir = opendir($rootdir);
        //读取目录文件
        $data = [];
        $num['dir'] = '';
        $num['file'] = '';
        while ($filename = readdir($dir)) {
            if ($filename !='.' && $filename != '..') {

                //根据文件和目录区分图标
                if (is_dir($filename)) {
                    $arr['icon'] = '&#xe622;';
                    $arr['sign'] = '1';
                    $num['dir'] ++;
                }else{
                    $arr['icon'] = $this->fileTypeIcon($filename);
                    $arr['sign'] = '0';
                    $num['file'] ++;
                }
                $arr['currdir'] = $rootdir.'\\'.$filename;//文件的绝对路径
                $arr['filename'] = $filename;
                $arr['size'] = filesize($filename); //文件大小 返回文件字节数
                $arr['ctime'] = filectime($filename); //文件创建时间
                $arr['mtime'] = filemtime($filename); //文件修改时间
                $data[] = $arr;
            }

        }
        $srr = array_column($data,'sign');  //取出数组中的标识列
        array_multisort($srr,SORT_DESC,$data); //按标识进行降序排列

        //实现数组分页
        $data = $this->arrPage($data,input('get.p'),'5');
        $this->assign([
                'curdir'    =>  $rootdir,
                'filename'  =>  $data['data'],
                'num'       =>  $num,
                'pagepar'   =>  $data['pagepar']   
            ]);
        return $this->fetch('file');
    }

    /**
     * 根据问价类型显示不同的图标
     *
     * @return \think\Response
     */
    private function fileTypeIcon($file = '')
    {   
        //截取文件后缀
        $str = strtolower(substr($file, strripos($file, '.')));
        $inco = '';
        switch ($str) {
            case '.php':
                $inco = '#icon-php';
                break;
            case '.xml':
                $inco = '#icon-xml';
                break;
            case '.png':
                $inco = '#icon-png';
                break;
            case '.html':
                $inco = '#icon-HTML';
                break;
            case '.jpg':
                $inco = '#icon-jpg';
                break;
            case '.gif':
                $inco = '#icon-GIF';
                break;
            case '.css':
                $inco = '#icon-CSS';
                break;
            case '.txt':
                $inco = '#icon-txt';
                break;
            case '.json':
                $inco = '#icon-json';
                break;
            case '.sql':
                $inco = '#icon-sql';
                break;
            case '.js':
                $inco = '#icon-js';
                break;
            default:
                $inco = '#icon-file-1';
                break;
        }
        return $inco;
    }

    /**
     * 数组分页
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function arrPage($data,$curr,$page=10)
    {   
        //求出总页数
        $totalPage = ceil(count($data)/$page);
        if($curr < '1') $curr = '1';
        if($curr > $totalPage) $curr = $totalPage;

        $arr = array_slice($data, ($curr-1)*$page,$page);  //取出数组中指定数量的元素

        return $data = [
            'data'=>$arr,
            'pagepar' => ['total'=>$totalPage,'curr'=>$curr]
        ];
    }

    /**
     * 文件删除
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function filedel(Request $request)
    {
        if($request->isAjax()){
            $file = $request->get('file');
            $file = urldecode($file);
            //判断目录是否存在
            if (is_dir($file)) {
                //以数组方式列出目录中的文件和目录
                $arr = scandir($file);

                //非空目录不允许删除
                if(count($arr) === 2){
                    @rmdir($file);
                    return json(['code'=>'1','msg'=>'目录删除成功！']);
                }else{
                    return json(['code'=>'0','msg'=>'非空目录(删除失败)']);
                }
                
            }

            //如果是文件
            if (is_file($file)) {
                @unlink($file);
                return json(['code'=>'1','msg'=>'文件删除成功！']);
            }

            return json(['code'=>'0','msg'=>'操作失败请稍后重试！']);

        }
    }

    /**
     * 文件目录重命名
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function reName(Request $request)
    {
        $file = $request->get('file');
        $filepath = $request->get('filepath');
        //将编码后的url字符串解码
        $filepath = urldecode($filepath);
        //新的文件名
        $newfile = dirname($filepath).DS.$file;  

        //对文件进行重命名
        if(file_exists($newfile)){
            return json(['code'=>'0','msg'=>'文件名已存在！']);
        }

        rename($filepath,$newfile);

        return json(['code'=>'1','msg'=>'操作成功！']);
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
