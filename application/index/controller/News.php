<?php


/**
 *	新闻资讯
 */

namespace app\index\controller;
use think\Controller;


class News extends Common {


	public function index() {

		return $this->fetch();
	}
}